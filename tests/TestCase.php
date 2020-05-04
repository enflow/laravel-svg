<?php

namespace Enflow\Svg\Test;

use Orchestra\Testbench\TestCase as TestbenchTestCase;

abstract class TestCase extends TestbenchTestCase
{
    protected array $packs = [
        'custom' => __DIR__ . '/fixtures/custom',
        'icons' => [
            'path' => __DIR__ . '/fixtures/icons',
            'auto_size_on_viewbox' => true,
        ],
    ];

    protected function getPackageProviders($app)
    {
        return [
            \Enflow\Svg\SvgServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('svg.packs', $this->packs);
    }
}
