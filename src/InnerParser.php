<?php

namespace Enflow\Svg;

use DOMElement;
use DOMNode;

class InnerParser
{
    public static function parse(Svg $svg)
    {
        return StaticCache::once(static::class . '@parse-' . $svg->id(), function () use ($svg) {
            return array_reduce(
                iterator_to_array(DomParser::node($svg)->childNodes),
                function ($carry, DOMNode $child) {
                    // Set default fill if not already defined.
                    if ($child instanceof DOMElement && ! $child->hasAttribute('fill')) {
                        $child->setAttribute('fill', 'currentColor');
                    }

                    return $carry . $child->ownerDocument->saveHTML($child);
                }
            );
        });
    }
}
