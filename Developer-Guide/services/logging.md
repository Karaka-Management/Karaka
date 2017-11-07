# Logging

The core provides two different logging outputs, one is a file output for low level logging such as exceptions, warnings and errors as well as a database logging for activity logging and higher level problems.

Both logging implementations provide the following logging functions for the different logging levels.

* `emergency()`
* `alert()`
* `critical()`
* `error()`
* `notice()`
* `info()`
* `debug()`
* `console()`
* `log()`

All functions take at least two parameters where one is the message and the other one is the optional context that should be injected into the message. 

```php
$log->error(FileLogger::MSG_FULL, ['message' => 'Log me!']);
```

## File Logging

The file logging should only be used for database and application problems. The file logging is part of the framework and is always available. The file logger implements the singleton pattern and can be aquired by calling the `getInstance()` function.

```php
$log = FileLogger::getInstance('logging/path', false);
```

Once initialized these two parameters are no longer required. The file logger will create a log file in the provided directory in the format `{Y-m-d}.log`.

## Client Side Logging

On the client side a logger is also implemented providing the same functions as described above. The only difference is that this logger can remote log messages. Logging messages will get forwarded to the server which will log these messages with the file logger.

```js
let log = jsOMS.Log.Logger.getInstance(true, false, true);
```
