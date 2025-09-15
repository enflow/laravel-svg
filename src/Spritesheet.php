<?php

namespace Enflow\Svg;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use LogicException;

class Spritesheet extends Collection implements Htmlable
{
    public bool $injected = false;

    public function queue(Svg $svg): void
    {
        $this->put($svg->id(), $svg);
    }

    public function __toString()
    {
        throw new LogicException('Spritesheet __toString disabled. Specify `toHtml` or `toStylesheet` manually');
    }

    public function toHtml(): HtmlString
    {
        // Regex ported from https://github.com/Hedronium/SpacelessBlade/blob/master/src/SpacelessBladeProvider.php
        return new HtmlString(preg_replace('/>\\s+</', '><', view('svg::spritesheet', [
            'spritesheet' => $this,
        ])->render()));
    }

    public function toStylesheet(): HtmlString
    {
        $css = view('svg::stylesheet')->render();

        $minified = preg_replace(
            [
                '/>\s+</',              // collapse whitespace between tags
                '/\R+/',                // remove line breaks
                '/\s{2,}/',             // collapse multiple spaces
                '~\s*([{}:;,])\s*~',    // trim spaces around CSS punctuation
                '/;(?=\s*})/',          // drop trailing semicolons before }
                '/(<style[^>]*>)\s+/',  // remove space right after <style ...>
            ],
            ['><', ' ', ' ', '$1', '', '$1'],
            trim($css)
        );

        return new HtmlString($minified);
    }
}
