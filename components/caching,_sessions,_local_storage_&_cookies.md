# Caching, Sessions, Local Storage & Cookies

## Caching

For caching the `CacheManager` provides access to the caching systems in place. Out of the box the CacheManager supports and automatically initializes either Redis or Memcached depending on the client configuration. The caching is not mandatory and therfor shouldn't be missuesed as in-memory database. It is not necessary to check if Redis or Memcached are available the CacheManager automatically handles the caching based on their existence.

### HTTP Cache

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

## Sessions

Sessions are handled via the `SessionManager`. Sessions can be set and manipulated from the web application as well as the socket or console application. 

### HTTP

The Http session will be saved automatically, there is no need to access the super global `$_SESSION`. Make sure to only modify session data using the SessionManager

### Socket & Console

The session will be stored and assoziated with the logged in user in memory. A disconnect or quit is considered as a logout and therefor results in the destruction of the session object of this user and will be empty for the next login.

## Local Storage


## Cookies

### PHP

Only use cookies when absolutely necessary. Most of the time session data or local storage is the prefered choice. The `CookieJar` class provides you with all the necessary functionality similar to the `SessionManager`. The super global `$_COOKIE` is also overwritten and shouldn't be used anywhere.

### JavaScript
