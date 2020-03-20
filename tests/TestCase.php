<?php

namespace Enflow\Svg\Test;

use Orchestra\Testbench\TestCase as TestbenchTestCase;

abstract class TestCase extends TestbenchTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Enflow\Svg\SvgServiceProvider::class,
        ];
    }
}
