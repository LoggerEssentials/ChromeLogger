# ChromeLogger
A psr-3 compatible [Chrome-Logger](https://craig.is/writing/chrome-logger) implementation

## Installation

`composer require logger/chrome`

PHP 5.6+ required.

## Usage

```php
$logger = new \Logger\ChromeLogger();
$logger->info('Hello world');
```