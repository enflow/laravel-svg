<?php

namespace Enflow\Svg\Test;

use Enflow\Svg\Exceptions\PackNotFoundException;
use Enflow\Svg\PackCollection;

class PackTest extends TestCase
{
    protected array $packs = [
        'custom' => __DIR__ . '/fixtures/custom',
    ];

    public function test_get_all_packs()
    {
        $this->assertCount(1, app(PackCollection::class)->all());
    }

    public function test_pack_lookup_method()
    {
        $pack = app(PackCollection::class)->find('custom');

        $this->assertStringEndsWith('fixtures/custom/clock.svg', $pack->lookup('clock'));
    }

    public function test_exception_on_non_existing_pack()
    {
        $this->expectException(PackNotFoundException::class);

        app(PackCollection::class)->find('non-existing');
    }

    public function test_manually_adding_pack()
    {
        app(PackCollection::class)->addPack('icons', [
            'path' => __DIR__ . '/fixtures/icons',
        ]);

        $this->assertNotEmpty(svg('clock')->pack('icons'));
    }

    public function test_manually_adding_packs()
    {
        app(PackCollection::class)->addPacks([
            'icons' => [
                'path' => __DIR__ . '/fixtures/icons',
            ],
        ]);

        $this->assertNotEmpty(svg('clock')->pack('icons'));
    }
}
