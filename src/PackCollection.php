<?php

namespace Enflow\Svg;

use Enflow\Svg\Exceptions\PackNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PackCollection extends Collection
{
    public static function fromConfig(array $config): self
    {
        return new static(collect($config)->map(function ($config, string $name) {
            return tap(new Pack, function (Pack $pack) use ($config, $name) {
                $pack->name = $name;
                $pack->paths = Arr::wrap(is_string($config) ? $config : ($config['paths'] ?? $config['path'] ?? null));
                $pack->autoSizeOnViewBox = $config['auto_size_on_viewbox'] ?? false;
            });
        }));
    }

    public function find(string $name): Pack
    {
        if ($pack = $this->get($name)) {
            return $pack;
        }

        throw PackNotFoundException::create($name);
    }
}
