<?php

namespace Enflow\Svg;

use DOMDocument;
use DOMNode;

class DomParser
{
    public static function node(Svg $svg): DOMNode
    {
        return StaticCache::once(static::class.'@node-'.$svg->id(), function () use ($svg) {
            $contentsWithoutComments = preg_replace('/<!--(.|\s)*?-->/', '', $svg->contents);

            $dom = new DOMDocument();
            @$dom->loadXML($contentsWithoutComments);

            return $dom->getElementsByTagName('svg')->item(0);
        });
    }
}
