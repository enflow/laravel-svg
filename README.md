# Using SVGs with easy

[![Latest Version on Packagist](https://img.shields.io/packagist/v/enflow/laravel-svg.svg?style=flat-square)](https://packagist.org/packages/enflow/laravel-svg)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/enflow/laravel-svg/run-tests?label=tests)
[![Total Downloads](https://img.shields.io/packagist/dt/enflow/document-replacer.svg?style=flat-square)](https://packagist.org/packages/enflow/laravel-svg)

The `enflow/laravel-svg` package provides a easy way include SVGs in your templates, which optimalisations for including SVGs inline by referencing a spritesheet.

## Installation
You can install the package via composer:

``` bash
composer require enflow/laravel-svg
```



Pushing the config file:
``` bash
php artisan vendor:publish --provider="Enflow\Svg\SvgServiceProvider"
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
