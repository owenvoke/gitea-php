# Gitea PHP

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-github-actions]][link-github-actions]
[![Style CI][ico-styleci]][link-styleci]
[![Total Downloads][ico-downloads]][link-downloads]
[![Buy us a tree][ico-treeware-gifting]][link-treeware-gifting]

An object oriented PHP wrapper for the Gitea API

## Requirements

- PHP >= 7.4
- A [PSR-17 implementation](https://packagist.org/providers/psr/http-factory-implementation)
- A [PSR-18 implementation](https://packagist.org/providers/psr/http-client-implementation)

## Install

Via Composer

```shell
composer require owenvoke/gitea guzzlehttp/guzzle:^7.4 http-interop/http-factory-guzzle:^1.2
```

We are decoupled from any HTTP messaging client with help by [HTTPlug](https://httplug.io).

## Usage

**Basic usage**

```php
// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

$client = new \OwenVoke\Gitea\Client();
$repositories = $client->user()->repositories();
```

**Authentication**

> Note: Gitea only supports authentication via an API token.

```php
use OwenVoke\Gitea\Client;
$client = new Client();
$client->authenticate($apiToken, null, Client::AUTH_ACCESS_TOKEN);
```

**Self-hosted Gitea instances**

The Gitea PHP wrapper can be configured to use an custom-hosted instance, rather than `gitea.com`.

```php
// Specify the URL of the Gitea instance on client initialization
$client = new \OwenVoke\Gitea\Client(null, null, 'https://gitea.example.com');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```shell
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email security@voke.dev instead of using the issue tracker.

## Credits

- [Owen Voke][link-author]
- [KNP Labs](https://github.com/KnpLabs) (based on [their GitHub client](https://github.com/KnpLabs/php-github-api))
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment you are required to buy the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to plant trees. If you support this package and contribute to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees [here][link-treeware-gifting].

Read more about Treeware at [treeware.earth][link-treeware].

[ico-version]: https://img.shields.io/packagist/v/owenvoke/gitea.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-github-actions]: https://img.shields.io/github/workflow/status/owenvoke/gitea-php/Tests.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/299549651/shield
[ico-downloads]: https://img.shields.io/packagist/dt/owenvoke/gitea.svg?style=flat-square
[ico-treeware-gifting]: https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen?style=flat-square

[link-packagist]: https://packagist.org/packages/owenvoke/gitea
[link-github-actions]: https://github.com/owenvoke/gitea-php/actions
[link-styleci]: https://styleci.io/repos/299549651
[link-downloads]: https://packagist.org/packages/owenvoke/gitea
[link-treeware]: https://treeware.earth
[link-treeware-gifting]: https://ecologi.com/owenvoke?gift-trees
[link-author]: https://github.com/owenvoke
[link-contributors]: ../../contributors
