<?php

namespace Enflow\Svg\Test;

use Enflow\Svg\Exceptions\PackNotFoundException;
use Enflow\Svg\Exceptions\SvgNotFoundException;
use Enflow\Svg\Pack;
use Enflow\Svg\PackCollection;
use Enflow\Svg\Spritesheet;
use Spatie\Snapshots\MatchesSnapshots;

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
}
