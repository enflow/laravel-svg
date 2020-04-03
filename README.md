# Using SVGs with easy

[![Latest Version on Packagist](https://img.shields.io/packagist/v/enflow/laravel-svg.svg?style=flat-square)](https://packagist.org/packages/enflow/laravel-svg)
![GitHub Workflow Status](https://github.com/enflow-nl/laravel-svg/workflows/run-tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/enflow/laravel-svg.svg?style=flat-square)](https://packagist.org/packages/enflow/laravel-svg)

The `enflow/laravel-svg` package provides a easy way include SVGs in your templates.

## Installation
You can install the package via composer:

``` bash
composer require enflow/laravel-svg
```

## Usage
You may use the `svg` helper in your templates

```blade
{{ svg('clock') }}

// Adding a class
{{ svg('clock')->class('mr-2') }}

// Adding an extra attribute
{{ svg('clock')->class('mr-2')->id('clock-icon') }}

// Specify the pack
{{ svg('clock')->pack('fas') }}
```

## Config

You may publish the config to set the packs that you are using:

Pushing the config file:
``` bash
php artisan vendor:publish --provider="Enflow\Svg\SvgServiceProvider"
```

## Packs
You may specify multiple packs that are used in your application. By default, only the `resources/img/svgs` pack is included, but you may specify additional icon sets like Font Awesome in your config. When the pack isn't specified when including the SVG, the first one that can be found in the order defined in your config will be used. You may overrule this behavior by calling the `pack` method on the `Enflow\Svg\Svg` class that's returned by the SVG helper.

```php
<?php

return [
    'packs' => [
        'custom' => resource_path('img/svgs/'),
        'fas' => [
            'path' => base_path('vendor/fortawesome/font-awesome/svgs/solid/'),
            'auto_size_on_viewbox' => true,
        ],
        'fal' => [
            'path' => base_path('vendor/fortawesome/font-awesome/svgs/light/'),
            'auto_size_on_viewbox' => true,
        ],
    ],
];
```

### Examples
#### Font Awesome 5 Free

##### Installing
`composer require fortawesome/font-awesome`

Reference: https://github.com/FortAwesome/Font-Awesome

##### Config
```php
<?php

return [
    'packs' => [
        'custom' => resource_path('img/svgs/'),
        'fas' => [
            'path' => base_path('vendor/fortawesome/font-awesome/svgs/solid/'),
            'auto_size_on_viewbox' => true,
        ],
    ],
];
```
#### Font Awesome 5 Pro

##### Installing

`yarn add @fortawesome/fontawesome-pro`

_Font Awesome 5 doesn't provide a composer package. We'll install it through our npm/yarn pipeline and use that path instead_

Reference: https://fontawesome.com/how-to-use/on-the-web/setup/using-package-managers

##### Config
```php
<?php

return [
    'packs' => [
        'custom' => resource_path('img/svgs/'),
        'fas' => [
            'path' => base_path('node_modules/@fortawesome/fontawesome-pro/svgs/solid/'),
            'auto_size_on_viewbox' => true,
        ],
    ],
];
```

## Middleware
This package includes the `Enflow\Svg\Middleware\InjectSvgSpritesheet` middleware which is automatically registered and added to your `web` group. 

This will add the SVG spritesheet to the top of your templates, where all unique SVGs are added. The SVGs rendered in your templates will reference this spritesheet. The reason for this is that in a loop, the SVG only is once in the body, instead of repeating it per row.

You may disable the automatic injection by setting the `register_middleware_automatically` to `false`:

##### config/svg.php
```php
<?php

return [
    'register_middleware_automatically' => false
];
```

### Using with other middleware
When using `enflow/laravel-svg` in combination with another middleware that must always be executed after the SVGs are injected in the response, you may use the $middlewarePriority logic on the Laravel router to ensure it's always run after. 

The order in this array is counterintuitive: at first must the `CacheResponse` middleware be specified, and then the SVG injection middleware. This is due to the way middleware responses are build. This ensures that first the SVGs are injected, and that complete response is cached.

Example for usage with [spatie/laravel-responsecache](https://github.com/spatie/laravel-responsecache)

##### app/Http/Kernel.php
```
protected $middlewarePriority = [
    ...
    \Spatie\ResponseCache\Middlewares\CacheResponse::class,
    \Enflow\Svg\Middleware\InjectSvgSpritesheet::class,
];
``` 

## Testing
``` bash
$ composer test
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security related issues, please email michel@enflow.nl instead of using the issue tracker.

## Credits
- [Michel Bardelmeijer](https://github.com/mbardelmeijer)
- [All Contributors](../../contributors)

## Special thanks
- github.com/jerodev/laravel-font-awesome for the idea
- github.com/adamwathan/blade-svg for the research
- github.com/spatie for the GitHub actions test workflow

## About Enflow
Enflow is a digital creative agency based in Alphen aan den Rijn, Netherlands. We specialize in developing web applications, mobile applications and websites. You can find more info [on our website](https://enflow.nl/en).

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
