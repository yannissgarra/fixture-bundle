# WebmunkeezFixtureBundle

This bundle brings fixtures to Symfony.

## Installation

Use Composer to install this bundle:

```console
$ composer require webmunkeez/fixture-bundle
```

Add the bundle in your application kernel:

```php
// config/bundles.php

return [
    // ...
    Webmunkeez\FixtureBundle\WebmunkeezFixtureBundle::class => ['dev' => true, 'test' => true],
    // ...
];
```