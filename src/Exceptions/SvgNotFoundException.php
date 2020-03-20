<?php

namespace Enflow\Svg\Exceptions;

use Enflow\Svg\Pack;
use Exception;

class SvgNotFoundException extends Exception implements SvgException
{
    public static function create(string $name, ?Pack $pack = null)
    {
        $pack = $pack ?? 'not specified';

        return new static("Pack '{$name}' is not defined. Options are: {$packs}");
    }
}
