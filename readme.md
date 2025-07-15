# Claude Flux Docs Laravel Package

A simple Laravel package that publishes a `claude-flux.md` documentation file to your project root.

## Installation

Install the package via Composer:

```bash
composer require petervandijck/claude-flux-docs
```

## Usage

Publish the `claude-flux.md` file to your project root:

```bash
php artisan vendor:publish --tag=claude-flux-docs
```

This will create a `claude-flux.md` file in your Laravel project's root directory.

## Requirements

- PHP 8.1 or higher
- Laravel 10.x, 11.x, or 12.x

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.