<?php

namespace Enflow\Svg\Test;

use Enflow\Svg\Spritesheet;
use Spatie\Snapshots\MatchesSnapshots;

class StylesheetTest extends TestCase
{
    use MatchesSnapshots;

    public function test_stylesheet_default(): void
    {
        config([
            'svg.stylesheet' => 'default',
        ]);

        $this->assertMatchesXmlSnapshot(app(Spritesheet::class)->toStylesheet()->toHtml());
    }

    public function test_stylesheet_layer_base(): void
    {
        config([
            'svg.stylesheet' => 'layer-base',
        ]);

        $this->assertMatchesXmlSnapshot(app(Spritesheet::class)->toStylesheet()->toHtml());
    }

    public function test_stylesheet_none(): void
    {
        config([
            'svg.stylesheet' => 'none',
        ]);

        $this->assertEmpty(app(Spritesheet::class)->toStylesheet()->toHtml());
    }
}
