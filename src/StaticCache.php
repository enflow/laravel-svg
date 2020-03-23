<?php

namespace Enflow\Svg;

use Closure;

class StaticCache
{
    protected static $cache = [];

    public static function once(string $id, Closure $closure)
    {
        if (array_key_exists($id, static::$cache)) {
            return static::$cache[$id];
        }

        return static::$cache[$id] = $closure();
    }
}
