<?php

namespace Enflow\Svg\Exceptions;

use Enflow\Svg\Svg;
use Exception;

class SvgInvalidException extends Exception implements SvgException
{
    public static function viewportInvalid(Svg $svg, string $viewPort)
    {
        $viewPort = empty($viewPort) ? '(empty)' : $viewPort;
        return new static("Svg '{$svg->name}' has an invalid viewPort defined. Must contain 4 numeric values split by spaces. Is: {$viewPort}");
    }
}
