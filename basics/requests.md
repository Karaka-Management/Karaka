# Requests

Requests can be either incoming requests such as http requests on the server side or outgoing requests such as ajax requests on the client side. At the same time it's also possible to generate outgoing requests on the server side for microservices as well as REST requests to third party APIs.

## Http Requests

Every request accepts a localization for localized responses, optionally the request URI can also be passed during initialization.

```
$request = new Request(new Localization(), new Http());
```

In case no URI is provided the request object initializes the current http request URI. The request object automatically removes all global request variables (e.g. $_GET) in case the current http request gets initialized. All the data will be available through:

```
$request->getData('queryName');
```

During the request initialization the UriBuilder will be set up as well. 

## Socket Requests

## Websocket Requests

## JavaScript Requests
