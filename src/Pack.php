<?php

namespace Enflow\Svg;

use Enflow\Svg\Exceptions\PackNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Pack
{
    public string $name;
    public array $paths;

    /**
     * Auto size on Viewbox means that the SVG will have an automatically generated width based on the viewport width and height.
     * The most common use case is when using the Font Awesome 5 set.
     * We'll automatically calculate the width, and add a CSS class to set the vertical alignment and height to a sensible default as well.
     *
     * @var bool
     */
    public bool $autoSizeOnViewBox = false;

    public function lookup(string $name): ?string
    {
        return collect($this->paths)->map(function (string $path) use ($name) {
            return rtrim($path, '/') . '/' . $name . '.svg';
        })->first(function ($filePath) {
            return file_exists($filePath);
        });
    }

    /**
     * @return Collection|Pack[]
     */
    public static function all(): Collection
    {
        return collect(config('svg.packs', []))->map(function ($config, string $name) {
            return tap(new static, function (self $pack) use ($config, $name) {
                $pack->name = $name;
                $pack->paths = Arr::wrap(is_string($config) ? $config : ($config['paths'] ?? $config['path'] ?? null));
                $pack->autoSizeOnViewBox = $config['auto_size_on_viewbox'] ?? false;
            });
        });
    }

    public static function get(string $name): Pack
    {
        if ($pack = static::all()->get($name)) {
            return $pack;
        }

        throw PackNotFoundException::create($name);
    }
}
