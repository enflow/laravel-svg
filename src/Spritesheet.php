<?php

namespace Enflow\Svg;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\Support\Htmlable;

class Spritesheet extends Collection implements Htmlable
{
    public bool $injected = false;

    public function queue(Svg $svg): void
    {
        $this->put($svg->id(), $svg);
    }

    public function toHtml(): HtmlString
    {
        // Regex ported from https://github.com/Hedronium/SpacelessBlade/blob/master/src/SpacelessBladeProvider.php
        return new HtmlString(preg_replace('/>\\s+</', '><', view('svg::spritesheet', ['spritesheet' => $this])->render()));
    }
}
