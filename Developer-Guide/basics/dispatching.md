# Dispatching

The dispatching is the follow up on the routing. In the dispatcher the route destination get resolved and executed. Dispatching can be performed on module instance methods, static functions and anonymous functions.

The result of the `dispatch()` call is an array of renderable views which will be rendered at the end when the response object is finalized.

## Basic

The dispatcher accepts a string representation of the method or static function which should be dispatched, a closure which should be executed or an array of the above.

The `dispatch()` function accepts additionally a variable amount of parameters which will be passed to the routed method/function.

### String

#### Module

The string representation for a module method is almost the same as the static function representation. The only difference is that a module method has only one colon `:` between the function name and the namespace.

```php
$dispatcher->dispatch('\My\Namespace:methodToCall', $methodToCallPara1, $methodToCallPara2, ...);
```

#### Static

The string representation for a module method is almost the same as the static function representation. The only difference is that a module method has two colons `::` between the function name and the namespace.

```php
$dispatcher->dispatch('\My\Namespace::staticToCall', $staticToCallPara1, $staticToCallPara2, ...);
```

### Closure

The closure simply takes a closure as first parameter which will be called and executed during the dispatching process.

```php
$dispatcher->dispatch(function($para1, $para2) { ... }, $staticToCallPara1, $staticToCallPara2, ...);
```

## Routing

The dispatcher accepts the resoults from the `route()` method of the router which is an array of routes.

```php
$dispatcher->dispatch($router->route($request))
```

Based on the function definition returned by the router it's possible to pass more parameters to the function such e.g. request and response objects.

```php
$dispatcher->dispatch($router->route($request), $request, $response)
```
