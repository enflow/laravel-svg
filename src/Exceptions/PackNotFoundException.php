<?php

namespace Enflow\Svg\Exceptions;

use Enflow\Svg\PackCollection;
use Exception;

class PackNotFoundException extends Exception implements SvgException
{
    public static function create(string $name)
    {
        $packs = app(PackCollection::class)->keys()->join(', ', ' and ');

        return new static("Pack '{$name}' is not defined. Options are: {$packs}");
    }
}
