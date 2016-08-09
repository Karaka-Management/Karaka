# Dispatching

The dispatching is the follow up on the routing. In the dispatcher the route destination get resolved and executed.

The dispatching is fairly simple as it only requires a single function call.

```
$this->dispatcher->dispatch($this->router->route($request))
```

Based on the function definition returned by the router it's possible to pass more parameters to the function such e.g. request and response objects.

```
$this->dispatcher->dispatch($this->router->route($request), $request, $response)
```

The result of the `dispatch` call is an array of results.