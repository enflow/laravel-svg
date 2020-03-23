<?php

namespace Enflow\Svg;

use Enflow\Svg\Middleware\InjectSvgSpritesheet;
use Illuminate\Support\ServiceProvider;

class SvgServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/svg.php' => config_path('svg.php'),
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../config/svg.php', 'svg');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'svg');

        $this->app->singleton(PackCollection::class, function () {
            return PackCollection::fromConfig(config('svg.packs', []));
        });
        $this->app->singleton(Spritesheet::class);

        $this->registerMiddleware();
    }

    private function registerMiddleware()
    {
        if (config('svg.register_middleware_automatically', true)) {
            $this->app['router']->pushMiddlewareToGroup('web', InjectSvgSpritesheet::class);
        }
    }
}
