# RandImgProvider for Faker generator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Faker provider for generating random images in your PHP projects. The default faker image provider, Lorem Pixel,
is fine but it has too many requests and slow down your testing environment. This is the main reason why i made this
PHP package.

## Install

Via Composer

``` bash
$ composer require randimg/faker-randimg-provider
```

## Usage

``` php
use Faker\Factory;
use Faker\Generator;
use Siro\RandImg\RandImgProvider;

$faker = Factory::create();
$faker->addProvider(new RandImgProvider($faker));

$faker->imageUrl(); // http://www.rand-img.com/720/480
$faker->imageUrl(300, 200); // http://www.rand-img.com/300/200
$faker->imageUrl(720, 480, 'sky');  // http://www.rand-img.com/720/480/sky
$faker->imageUrl(720, 480, 'food', ['rand' => true]);   // http://www.rand-img.com/720/480/food?rand=4234532
$faker->imageUrl(720, 480, 'food', ['rand' => true, 'blur' => 4, 'gray' => 1]); // http://www.rand-img.com/720/480/food?rand=4234532&blur=4&gray=1

$faker->image(__DIR__, 200, 200);   // image path and filename joined
$faker->image(__DIR__, 200, 200);   // image path and filename joined
$faker->gif();  // gif path and filename
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email siro_diaz@yahoo.com instead of using the issue tracker.

## Credits

- [Siro Díaz Palazón][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/randimg/faker-randimg-provider.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/SiroDiaz/RandImgProvider/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/SiroDiaz/RandImgProvider.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/SiroDiaz/RandImgProvider.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/randimg/faker-randimg-provider.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/randimg/faker-randimg-provider
[link-travis]: https://travis-ci.org/SiroDiaz/RandImgProvider
[link-scrutinizer]: https://scrutinizer-ci.com/g/SiroDiaz/RandImgProvider/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/SiroDiaz/RandImgProvider
[link-downloads]: https://packagist.org/packages/SiroDiaz/RandImgProvider
[link-author]: https://github.com/SiroDiaz
[link-contributors]: ../../contributors
