<?php

namespace Enflow\Svg\Exceptions;

use Exception;

class PackNotFoundException extends Exception implements SvgException
{
    public static function create(string $name)
    {
        $packs = Pack::all()->keys()->join(', ', ' and ');

        return new static("Pack '{$name}' is not defined. Options are: {$packs}");
    }
}
