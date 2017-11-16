# Uri

The `UriFactory` is used in order to build URIs. The factory generates the URIs based on a raw uri as well as defined parameters and placeholders. The uri factory is available for the backend as well as the frontend and operate mostly the same and provide similar functionlity.

## Parameters

The raw uri string supports parameters that will be replaced with manual or default values. Parameters are always enclosed by `{}` and have a special prefix such as `#./?@$%`

```php
$rawUri = 'http://www.yoururl.com/en/some/{/path}?foo=bar&id={@data}'
```

These placeholders will be filled by values that are defined by the `setQuery()` function.

```php
UriFactory::setQuery('/path', 'thing');
UriFactory::setQuery('@data', 1);
UriFactory::build($rawUri) // http://www.yoururl.com/en/some/thing?foo=bar&id=1
```

It is possible to simply use the current uri and simply append parameters if you only want to change or set additional query parameters.

```
{%}&another={@value}
```

### Default Parameters

Some default parameters can be used for easier use.

* /base = base uri (e.g. http://www.yoururl.com/basepath)
* /scheme = current scheme (e.g. http)
* /host = current host (e.g. www.yoururl.com)
* /lang = current language (e.g. en)
* ?foo = value of the specified parameter
* ? = current query
* % = current uri
* # = fragment
* / = root
* :port = port
* :user = user
* :pass = password

### Frontend Parameters

While it's also possible to define parameters at the frontend and make use of the default values certain prefixes have a special meaning.

* #somid = value of the element with the specified id
* .somclass = values of the elements with the specified class

### Dynamic Parameters

Sometimes a parameter shouldn't be globally defined but is necessary to parse for a specific uri, in that case it's possible to pass an array or object of parameter definitions to the build function where the key is the parameter key and the value is the parameter value it should replace.

```js
jsOMS.Uri.UriFactory.build('yoururl.com/en/some/{/path}?id={@data}', {'@data': 1});
```

The match array/object takes priority over the default parameters which means you can overwrite them for a specific uri.