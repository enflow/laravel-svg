<?php

namespace Enflow\Svg;

use Enflow\Svg\Exceptions\SvgMustBeRendered;
use Enflow\Svg\Exceptions\SvgNotFoundException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Htmlable;

class Svg implements Htmlable, Renderable
{
    public string $name;
    public ?Pack $pack = null;
    /** @readonly */
    public string $contents;
    private Collection $attributes;

    public function __construct(string $name)
    {
        $this->name = $name;

        $this->attributes = collect(); // PHP 7.4 doesn't support defaults by function.
    }

    public function id(): string
    {
        return $this->pack->name . '-' . $this->name;
    }

    /**
     * @param string|Pack $pack
     * @return $this
     * @throws Exceptions\PackNotFoundException
     */
    public function pack($pack): self
    {
        if (!$pack instanceof Pack) {
            $pack = app(PackCollection::class)->find($pack);
        }

        $this->pack = $pack;

        return $this;
    }

    public function __call($method, $args): self
    {
        $this->attributes->put(Str::snake($method, '-'), $args[0]);

        return $this;
    }

    public function toHtml(): string
    {
        $this->prepareForRendering();

        app(Spritesheet::class)->queue($this);

        return vsprintf('<svg%s %s><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#%s"></use></svg>', [
            $this->sizingAttributes(),
            $this->renderAttributes(),
            $this->id()
        ]);
    }

    public function __toString()
    {
        return $this->toHtml();
    }

    public function render()
    {
        return $this->toHtml();
    }

    private function prepareForRendering()
    {
        $packs = app(PackCollection::class);

        foreach ($this->pack ? [$packs->get($this->pack->name)] : $packs as $pack) {
            if ($path = $pack->lookup($this->name)) {
                $this->pack = $pack;

                $this->contents = StaticCache::once(static::class . '@' . $this->id() . '-' . $path, function () use ($path) {
                    return file_get_contents($path);
                });

                return;
            }
        }

        throw SvgNotFoundException::create($this->name);
    }

    public function inner()
    {
        $this->ensureRendered();

        return InnerParser::parse($this);
    }

    public function viewBox()
    {
        $this->ensureRendered();

        return ViewboxParser::parse($this);
    }

    private function sizingAttributes()
    {
        $this->ensureRendered();

        if ($this->pack->autoSizeOnViewBox) {
            return sprintf(' width="%sem"', round($this->viewBox()[2] / $this->viewBox()[3], 4));
        }

        $svgDom = DomParser::node($this);

        [$width, $height] = [$svgDom->getAttribute('width'), $svgDom->getAttribute('height')];

        return ($width ? sprintf(' width="%s"', $width) : null) . ($height ? sprintf(' height="%s"', $height) : null);
    }

    private function renderAttributes()
    {
        return collect([
            'class' => $this->pack->autoSizeOnViewBox ? 'svg-auto-size' : null,
            'aria-hidden' => 'true',
            'focusable' => 'false',
            'role' => 'img',
        ])
            ->pipe(function (Collection $collection) {
                return $collection->merge(
                    $this->attributes->map(function ($value, $key) use ($collection) {
                        return trim($collection->get($key) . ' ' . $value);
                    })
                );
            })
            ->filter()
            ->map(function ($value, $key) {
                if (is_int($key)) {
                    return $value;
                }
                return sprintf('%s="%s"', $key, $value);
            })
            ->values()
            ->implode(' ');
    }

    private function ensureRendered()
    {
        if (empty($this->contents)) {
            throw SvgMustBeRendered::create($this);
        }
    }
}
