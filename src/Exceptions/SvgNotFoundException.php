<?php

namespace Enflow\Svg\Exceptions;

use Enflow\Svg\Pack;
use Exception;

class SvgNotFoundException extends Exception implements SvgException
{
    public static function create(string $name)
    {
        return new static("SVG '{$name}' could not be found.");
    }
}
