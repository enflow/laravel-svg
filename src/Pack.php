<?php

namespace Enflow\Svg;

class Pack
{
    public string $name;

    public array $paths = [];

    /**
     * Auto size on viewbox means that the SVG will have an automatically generated width based on the viewport width and height.
     * We'll automatically calculate the width, and add a CSS class to set the vertical alignment and height to a sensible default as well.
     *
     * The most common use case is when using the Font Awesome 5 set.
     */
    public bool $autoSizeOnViewBox = false;

    /**
     * Auto discovery defines is the pack is searched when no specific pack is defined in the icon lookup.
     * Use case: we have a pack available but want to ensure the user must opt-in to it's usage.
     */
    public bool $autoDiscovery = true;

    public function lookup(string $name): ?string
    {
        return StaticCache::once(static::class.'@lookup-'.$this->name.'-'.$name, function () use ($name) {
            return collect($this->paths)
                ->map(fn (string $path) => rtrim($path, '/').'/'.$name.'.svg')
                ->first(fn ($filePath) => file_exists($filePath));
        });
    }
}
