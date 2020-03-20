<?php

namespace Enflow\Svg\Exceptions;

use Enflow\Svg\Svg;
use Exception;

class SvgMustBeRendered extends Exception implements SvgException
{
    public static function create(Svg $svg)
    {
        return new static("Svg '{$svg->name}' must be rendered before using this method.");
    }
}
