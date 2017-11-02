# Cookies

## PHP

Only use cookies when absolutely necessary. Most of the time session data or local storage is the prefered choice. The `CookieJar` class provides you with all the necessary functionality similar to the `SessionManager`. The super global `$_COOKIE` is also overwritten and shouldn't be used anywhere.

## JavaScript
