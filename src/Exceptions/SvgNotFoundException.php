<?php

namespace Enflow\Svg\Exceptions;

use Exception;

class SvgNotFoundException extends Exception implements SvgException
{
    public static function create(string $name, array $suggestions = []): self
    {
        $message = "SVG '{$name}' could not be found.";

        if (! empty($suggestions)) {
            $message .= ' Did you mean: '.implode(', ', array_map(fn (string $s) => "'{$s}'", $suggestions)).'?';
        }

        return new static($message);
    }
}
