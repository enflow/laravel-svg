<?php

namespace Enflow\Svg;

use Enflow\Svg\Exceptions\PackNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PackCollection extends Collection
{
    public static function fromConfig(array $config): self
    {
        return (new static)->addPacks($config);
    }

    public function addPacks(array $config): self
    {
        collect($config)->each(function ($config, $name) {
            $this->addPack($name, $config);
        });

        return $this;
    }

    public function addPack(string $name, $config): self
    {
        return $this->put($name, tap(new Pack, function (Pack $pack) use ($config, $name) {
            $pack->name = $name;
            $pack->paths = Arr::wrap(is_string($config) ? $config : ($config['paths'] ?? $config['path'] ?? null));
            $pack->autoSizeOnViewBox = $config['auto_size_on_viewbox'] ?? false;
            $pack->autoDiscovery = $config['auto_discovery'] ?? true;
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
