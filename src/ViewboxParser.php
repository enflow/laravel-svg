<?php

namespace Enflow\Svg;

use Enflow\Svg\Exceptions\SvgInvalidException;

class ViewboxParser
{
    public static function parse(Svg $svg)
    {
        return StaticCache::once(static::class . '@parse' . $svg->id(), function () use ($svg) {
            $viewBox = DomParser::node($svg)->getAttribute('viewBox');

            $viewBoxParts = array_map('intval', explode(' ', $viewBox));

            if (count($viewBoxParts) !== 4) {
                throw SvgInvalidException::viewportInvalid($this, $viewBox);
            }

            return $viewBoxParts;
        });
    }
}
