<?php

use Enflow\Svg\Svg;
use Enflow\Svg\Spritesheet;

if (!function_exists('svg')) {
    function svg(string $name)
    {
        return new Svg($name);
    }
}
