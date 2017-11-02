# Security Guidelines

## CSRF

The tool to protect clients from CSRF is a randomly generated CSRF token, that can be used inside the URI generator. It's highly recomended to make use of this token whenever possible to reduce the risk of CSRF attacks.

Example usage:

```
<form action="<?= UriFactory::build('/{/lang}/api/path?csrf={$CSRF}')" ...>
    ...
</form>
```

Now the application will receive the automatically generated CSRF token as query parameter for further use. If the CSRF token is not the same as the one assoziated with the client on the server side the client will receive a 403 HTTP response. The CSRF however doesn't have be specified, if that's the case **every module itself must make sure wheter a valid CSRF token is required** or not. The reason for this is that third party requests are a possibility as well, and sharing the private CSRF token would render it useless.

Since the validation of the CSRF token is performed automatically it is only necessary to check the existence, since if it exists it has to be valid.

Example usage in a module handling a API request:

```
if($request->getData('CSRF') === null) {
    $response->setStatusCode(RequestStatusCode::R_403);
        
    /* optional */
    $response->set($request->__toString(), new Notify('Unknown referrer!', NotifyType::INFO));
    
    return;
}
```

### When do I check for the CSRF token validity/existence?

Always! Except the request has the potential to come from third party referrers. Here a few examples of requests that must always have a valid CSRF token:

1. Login/logout
2. Creating/updating/deleting something
3. Uploading media files
4. Changes in user settings

Here some examples of requests that **MAY** not need a validation (mostly API GET requests):

1. Get news posts
2. Get last log message

It's important to understand that the CSRF token is not equivalent with authentication or API token. Clients can be logged out and still need a CSRF token and obviously vice versa.

## Headers

The following headers must be set for every web application. By default they are already set in the `WebApplication` which gets expanded by all other web applications.

### Content-Security-Policy

Scripts and frames must be provided by the own server or google. This is important in order to prevent the injection of other scripts and clickjacking. Inline javascript is prohibited and may only be defined in the application and not in any modules.

The default CSP looks like the following:

```
$response->getHeader()->set('content-security-policy', 'script-src \'self\'; child-src \'self\'', true);
```

In order to whitelist inline javascript you can use the following logic. This however requires you to know the inline script beforehand `$script`. After setting the CSP header they automatically get locked so that further changes are not possible. This is a security measure in order to prevent any malicious adjustments. 

```
$response->getHeader()->set('content-security-policy', 'script-src \'self\' \'sha256-' . base64_encode(hash('sha256', $script, true)) . '\'; child-src \'self\'', true);
```

### X-XSS-Protection

This header tells the client browser to use local xss protection if available.

```
$response->getHeader()->set('x-xss-protection', '1; mode=block');
```

### X-Content-Type-Options

By using this header browsers which support this feature will ignore the content/mime and recognize the file by the provided header only.

```
$response->getHeader()->set('x-content-type-options', 'nosniff');
```

### X-Frame-Options

The x-frame-options is providing the same protection for frames as the content-security-policy header. Please only use this header in addition to the content-security-policy if you have to but make sure the rules don't contradict with the content-security-policy.

```
$response->getHeader()->set('x-frame-options', 'SAMEORIGIN');
```

## Super globals

Super globals are not available througout the application and the values can only be accesed through middleware classes like:

* SessionManager
* CookieJar
* Request
* Response

In some cases super globals will even be overwritten by values from these classes before generating a response. Do not directly access super globals!

## Input validation

Input validation be implemented on multiple levels.

1. Regex validation in html/javascript by using the `pattern=""` attribute
2. Type hints for method parameters and method returns wherever possible.
3. Making use of the `Validation` classes as much as possible
4. **Don't** sanitize at all! Accept or dismiss.

## Inclusion and file paths

Be vigilant of where and how the path for the following scenarios comes from:

1. `include $path;`
2. `fopen($path);`
3. `file_get_contents('../relative/path/to/' . $path);`
4. `mkdir($path);`

These are just a few examples but it is very important to make sure, that these paths only have access to wherever the programmer intended them for. At first it is always a good idea to get the `$path = realpath($path)` of a path in order to make sure the path exists and for further validation.

Example usage:

```
if(($pathNew = realpath($path)) === false || strpos($pathNew, self::MODULE_PATH) === false) {
    throw new PathException($path);
}
```

The example throws an exception if the path either doesn't exist or is trying to access a path that doesn't contain the path defined in `self::MODULE_PATH`. Another validation could be:

```
if(($pathNew = realpath($path)) === false || !Validator::startsWith($pathNew, ROOT_PATH)) {
    throw new PathException($path);
}
```

This example now is not only checking if the path exists and if it contains a path element, it also makes sure that the path is inside the application root path.