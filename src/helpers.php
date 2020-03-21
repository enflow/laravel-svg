<?php

use Enflow\Svg\Svg;

if (!function_exists('svg')) {
    function svg(string $name): Svg
    {
        return new Svg($name);
    }
}
