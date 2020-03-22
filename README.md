# Using SVGs with easy

[![Latest Version on Packagist](https://img.shields.io/packagist/v/enflow/laravel-svg.svg?style=flat-square)](https://packagist.org/packages/enflow/laravel-svg)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/enflow/laravel-svg/run-tests?label=tests)
[![Total Downloads](https://img.shields.io/packagist/dt/enflow/document-replacer.svg?style=flat-square)](https://packagist.org/packages/enflow/laravel-svg)

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

## Icons
We recommend including icons via composer or npm/yarn. This will ensure it's handelled correctly with a package manager, and this library will try to lookup those icons trough the configured paths.

## Packs
You may specify multiple packs that are used in your application. By default, only the `resources/img/svgs` pack is included, but you may specify additional icon sets like Font Awesome in your config. When the pack isn't specified when including the SVG, the first one that can be found in the order defined in your config will be used. You may overrule this behavoir by calling the `pack` method on the `Enflow\Svg\Svg` class that's returned by the SVG helper.

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

## Config

You may publish the config to set the packs that you are using:

Pushing the config file:
``` bash
php artisan vendor:publish --provider="Enflow\Svg\SvgServiceProvider"
```

Example config:
```php
<?php

return [
    'packs' => [
        'custom' => resource_path('img/svgs/'),
        'fas' => [
            'paths' => [
                base_path('node_modules/@fortawesome/fontawesome-pro/svgs/solid/'),
                base_path('vendor/@fortawesome/fontawesome-pro/svgs/solid/')
            ],
            'auto_size_on_viewbox' => true,
        ],
        'fal' => [
            'path' => base_path('node_modules/@fortawesome/fontawesome-pro/svgs/light/'),
            'auto_size_on_viewbox' => true,
        ],
    ],
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

## About Enflow
Enflow is a digital creative agency based in Alphen aan den Rijn, Netherlands. We specialize in developing web applications, mobile applications and websites. You can find more info [on our website](https://enflow.nl/en).

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
