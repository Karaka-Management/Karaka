## Cache

For caching the `CacheManager` provides access to the caching systems in place. Out of the box the CacheManager supports and automatically initializes either Redis or Memcached depending on the client configuration. The caching is not mandatory and therfor shouldn't be missuesed as in-memory database. It is not necessary to check if Redis or Memcached are available the CacheManager automatically handles the caching based on their existence.

### HTTP Cache

By default only stylesheets, javascript and layout images as well as module images are cached. Everything else is considered volatile and not cached. If a response specific response should be cached feel free to use the response header:

Example usage for 30 days caching:

```php
$resposne->setHeader('Cache-Control', 'Cache-Control: max-age=2592000');
```

In order to trigger a re-cache of stylesheets or javascript files make sure to update the version in the `Controller.php` file. This way version updates will result in a new virtual file uri and result in a re-cache.

Example usage:

```php
$head->addAsset(AssetType::JS, $request->getUri()->getBase() . 'Modules/Media/Controller.js?v=' . self::MODULE_VERSION);
```