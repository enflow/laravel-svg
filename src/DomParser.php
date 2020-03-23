<?php

namespace Enflow\Svg;

use DOMDocument;
use DOMNode;

class DomParser
{
    public static function node(Svg $svg): DOMNode
    {
        return StaticCache::once(static::class . '@node-' . $svg->id(), function () use ($svg) {
            $dom = new DOMDocument();
            @$dom->loadXML($svg->contents);

            return $dom->getElementsByTagName("svg")->item(0);
        });
    }
}
