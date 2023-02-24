<?php

namespace Enflow\Svg\Exceptions;

use Exception;

class SvgNotFoundException extends Exception implements SvgException
{
    public static function create(string $name): self
    {
        return new static("SVG '{$name}' could not be found.");
    }
}
