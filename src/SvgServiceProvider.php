<?php

namespace Enflow\Svg;

use Enflow\Svg\Middleware\InjectSvgSpritesheet;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class SvgServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/svg.php' => config_path('svg.php'),
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../config/svg.php', 'svg');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'svg');

        $this->app->singleton(Spritesheet::class);

        $this->registerBladeTag();

        $this->registerMiddleware();
    }

    private function registerBladeTag()
    {
        Blade::directive('svg', function ($expression) {
            return "<?php echo svg($expression)->toHtml(); ?>";
        });
    }

    private function registerMiddleware()
    {
        if (config('svg.register_middleware_automatically', true)) {
            $this->app['router']->pushMiddlewareToGroup('web', InjectSvgSpritesheet::class);
        }
    }
}
