# Routing

Routing allows to bind a string representation to a function. This is required in order to execute request specific code segments.
Routes are defined in a uniform manner for all different application types such as http, socket or console.

## Routes

Routes are defined as RegEx. It is recommended to match the desired route as closely as possible and provide both `^` at the beginning and `$` at the end of the route.

Resolving a route can be done by providing a request to the router

```php
$router->route(new Request());
```

or a route

```php
$router->route('foo/bar', RouteVerb::GET);
```

The result is an array of either string references or closures.

## Closure

For routes it's possible to define a `\Closure` which will get returned upon using the specified route.

```php
$router->add('foo/bar', function() { 
	return 'Hellow World';
});
```

Routes can have different verbs which are derived from the HTTP verbs. Routes that get assigned a verb will only be matched if the route and the routing verb match.

```
$this->router->add('foo/bar', function() { 
	return 'Hellow World';
}, RouteVerb::GET | RouteVerb::SET);
```

## Route Parameters

<coming soon>

## Reference

Instead of defining closures it's possible to define a string representation of the destination that should be called.

```
$this->router->add('foo/bar', '\foo\controller:barFunction');
```

Static functions can be defined in the following fashion:

```
$this->router->add('foo/bar', '\foo\controller::barFunction');
```

## Import

While routes can be added manually to the router it's also possible to import a list of routes through the file import function.

```
$this->router->importFromFile($path);
```

The routing file must have the folloing structure:

```
<?php return [
	'{ROUTE_STRING}' => [
		[
			'dest' => {CLOSURE/REFERENCE_STRING},
			'verb' => {VERB_1 | VERB_2},
		],
		[
			'dest' => {CLOSURE/REFERENCE_STRING},
			'verb' => {VERB_3},
		],
	],
	'{ANOTHER_ROUTE_STRING}' => [ ... ],
];
```

In this schematic the first route has different destinations depending on the verb.