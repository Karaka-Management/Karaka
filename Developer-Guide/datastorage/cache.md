# Cache

For caching the `CacheManager` provides access to the caching systems in place. Out of the box the CacheManager supports and automatically initializes either Redis or Memcached depending on the client configuration. The caching is not mandatory and therfor shouldn't be missuesed as in-memory database. It is not necessary to check if Redis or Memcached are available the CacheManager automatically handles the caching based on their existence.

## HTTP Cache

By default only stylesheets, javascript and layout images as well as module images are cached. Everything else is considered volatile and not cached. If a response specific response should be cached feel free to use the response header:

Example usage for 30 days caching:

```
$resposne->setHeader('Cache-Control', 'Cache-Control: max-age=2592000');
```

In order to trigger a re-cache of stylesheets or javascript files make sure to update the version in the `Controller.php` file. This way version updates will result in a new virtual file uri and result in a re-cache.

Example usage:

```
$head->addAsset(AssetType::JS, $request->getUri()->getBase() . 'Modules/Media/Controller.js?v=' . self::MODULE_VERSION);
```

## FileCache

The `FileCache` provides file caching of data on a single file basis. Every cache object will be stored in a sperate file on the local file system. The file cache doesn't support remote caching. The `FileCache` serializes and unserializes the data/object by invoking the corresponding serialization and unserialization functions. Scalars and array will be handled by the cache internally.

### Storage

The cache key used will be used for the file storage. Invalid path characters used within the cache key will be replaced. The character `/` used inside the key string can be used to generate subdirectories in the cache directory.