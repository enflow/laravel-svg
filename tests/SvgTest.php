<?php

namespace Enflow\Svg\Test;

use Enflow\Svg\Exceptions\SvgMustBeRendered;
use Enflow\Svg\Exceptions\SvgNotFoundException;
use Enflow\Svg\Spritesheet;
use Enflow\Svg\Svg;
use Illuminate\Support\Facades\Request;

class SvgTest extends TestCase
{
    use Snapshots;

    protected array $packs = [
        'custom' => __DIR__ . '/fixtures/custom',
        'auto-discovery-disabled' => [
            'path' => __DIR__ . '/fixtures/icons',
            'auto_size_on_viewbox' => true,
            'auto_discovery' => false,
        ],
        'icons' => [
            'path' => __DIR__ . '/fixtures/icons',
            'auto_size_on_viewbox' => true,
        ],
    ];

    public function test_svg_rendering()
    {
        $svg = svg('clock'); // Get from "custom", the first of the array

        $this->assertMatchesXmlSnapshot($svg->render());
        $this->assertEquals($svg->pack->name, 'custom');
    }

    public function test_auto_size_for_svg_rendering()
    {
        /** @var Svg $svg */
        $svg = svg('house')->class('mr-4'); // Get from "icons"

        $rendered = $svg->render();

        $this->assertMatchesXmlSnapshot($rendered);
        $this->assertEquals($svg->pack->name, 'icons');
        $this->assertStringContainsString('1.125em', $rendered);
        $this->assertStringContainsString('svg-auto-size', $rendered);
        $this->assertStringContainsString('mr-4', $rendered);
        $this->assertStringContainsString('focusable="false"', $rendered);
    }

    public function test_auto_discovery_disabled_pack_is_used_when_specific()
    {
        /** @var Svg $svg */
        $svg = svg('house')->pack('auto-discovery-disabled'); // Get from "auto-discovery-disabled"
        $svg->render();
        $this->assertEquals($svg->pack->name, 'auto-discovery-disabled');
    }

    public function test_viewbox_parsing()
    {
        /** @var Svg $svg */
        $svg = svg('house');

        $svg->render();

        $this->assertEquals('0 0 576 512', implode(' ', $svg->viewBox()));
    }

    public function test_all_render_methods_contain_the_same()
    {
        $svg = svg('clock');

        $this->assertEquals($svg->render(), $svg->toHtml());
        $this->assertEquals($svg->toHtml(), (string)$svg);
        $this->assertEquals($svg->render(), (string)$svg);
    }

    public function test_that_every_render_is_the_same()
    {
        // First render a complete separate one, so the spritesheet isn't empty.
        svg('clock');

        $svgOne = svg('house');
        $svgTwo = svg('house');

        $this->assertEquals($svgOne->render(), $svgTwo->render());
    }

    public function test_that_custom_svg_takes_over_width_and_height_from_source()
    {
        $this->assertMatchesXmlSnapshot(svg('fixed-width-height')->render());
    }

    public function test_exception_when_rendering_non_existing_svg()
    {
        $this->expectException(SvgNotFoundException::class);

        $this->assertInstanceOf(Svg::class, svg('non-existing'));

        svg('non-existing')->toHtml();
    }

    public function test_exception_when_using_viewbox_method_without_rendering()
    {
        $this->expectException(SvgMustBeRendered::class);

        svg('house')->viewBox();
    }

    public function test_that_svg_renders_inline_if_set()
    {
        $this->assertMatchesXmlSnapshot(svg('clock')->inline()->render());
    }

    public function test_that_svg_inline_includes_viewbox()
    {
        $this->assertStringContainsString('viewBox', svg('clock')->inline()->render());
    }

    public function test_that_svg_inline_removes_comment()
    {
        $this->assertStringNotContainsString('<!--', svg('with-comment')->inline()->render());
    }
}
