<?php

namespace Enflow\Svg;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class Spritesheet implements Htmlable
{
    /** @var Collection */
    public $svgs;

    public function __construct()
    {
        $this->clear();
    }

    public function add(Svg $svg)
    {
        $this->svgs->put($svg->id(), $svg);
    }

    public function clear()
    {
        $this->svgs = collect();
    }

    public function toHtml()
    {
        // Regex ported from https://github.com/Hedronium/SpacelessBlade/blob/master/src/SpacelessBladeProvider.php
        return preg_replace('/>\\s+</', '><', view('svg::spritesheet', ['svgs' => $this->svgs])->render());
    }
}
