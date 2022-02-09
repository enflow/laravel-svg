<?php

use Enflow\Svg\Spritesheet;
use Enflow\Svg\Svg;

if (! function_exists('svg')) {
    function svg(string $name): Svg
    {
        return new Svg($name);
    }
}

if (! function_exists('spritesheet')) {
    function spritesheet(): Spritesheet
    {
        return app(Spritesheet::class);
    }
}
