<?php

namespace Enflow\Svg;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class Spritesheet extends Collection implements Htmlable
{
    public bool $injected = false;

    public function queue(Svg $svg): void
    {
        $this->put($svg->id(), $svg);
    }

    public function toHtml()
    {
        // Regex ported from https://github.com/Hedronium/SpacelessBlade/blob/master/src/SpacelessBladeProvider.php
        return preg_replace('/>\\s+</', '><', view('svg::spritesheet', ['spritesheet' => $this])->render());
    }
}
