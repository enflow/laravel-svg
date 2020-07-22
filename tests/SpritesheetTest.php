<?php

namespace Enflow\Svg\Test;

use Enflow\Svg\Exceptions\SvgMustBeRendered;
use Enflow\Svg\Exceptions\SvgNotFoundException;
use Enflow\Svg\Spritesheet;
use Enflow\Svg\Svg;

class SpritesheetTest extends TestCase
{
    use Snapshots;

    public function test_spritesheet()
    {
        $this->assertCount(0, app(Spritesheet::class));
        $this->assertMatchesTextSnapshot(app(Spritesheet::class));

        $this->assertMatchesXmlSnapshot(svg('clock')->render());

        $this->assertCount(1, app(Spritesheet::class));

        // We don't use 'assertMatchesHtmlSnapshot' as this adds a <body> etc. around the test-subject.
        // This is fine locally, but fails in the GitHub actions matrix.
        $this->assertMatchesTextSnapshot(app(Spritesheet::class));

        svg('clock')->render();
        $this->assertCount(1, app(Spritesheet::class));
    }

    public function test_spritesheet_helper()
    {
        svg('clock')->render();

        $this->assertCount(1, spritesheet());
    }

    public function test_that_svg_is_only_once_in_spritesheet()
    {
        svg('clock')->render();
        svg('clock')->render();
        svg('house')->render();

        $spritesheet = app(Spritesheet::class);
        $this->assertCount(2, $spritesheet);
        $this->assertEquals(2, substr_count($spritesheet->toHtml(), '<symbol'));
    }
}
