# Php

The php code needs to be php 7 compliant. No php 7 deprecated or removed elements, functions or practices are allowed (e.g. short open tag).

##  Php Tags

PHP code MUST use the long `<?php ?>` tags or the short-echo `<?= ?>` tags; it MUST NOT use the other tag variations.

## Character Encoding

PHP code MUST use only UTF-8 without BOM

## Side Effects

A file SHOULD declare new symbols (classes, functions, constants, etc.) and cause no other side effects, or it SHOULD execute logic with side effects, but SHOULD NOT do both.

The phrase "side effects" means execution of logic not directly related to declaring classes, functions, constants, etc., merely from including the file.

"Side effects" include but are not limited to: generating output, explicit use of require or include, connecting to external services, modifying ini settings, emitting errors or exceptions, modifying global or static variables, reading from or writing to a file, and so on.

## Namespace and Class Names

Namespaces and classes MUST follow an "autoloading" PSR: [PSR-0, PSR-4].

This means each class is in a file by itself, and is in a namespace of at least one level: a top-level vendor name.

Class names MUST be declared in StudlyCaps.

## Constants

Class constants MUST be declared in all upper case with underscore separators.

## Methods

Method names MUST be declared in camelCase().

## Php in html

Php code embedded into template files SHOULD use the alternative syntax for control structures in order to improve the readability:

```php
if($a === 5) : ?>
    <p>This is html</p>
<?php endif; ?>
```

## Deprecated functions and variables

The following functions and (super-) global variables MUST NOT be used.

* `extract()`
* `parse_str()`
* `int_set()`
* `putenv()`
* `eval()`
* `assert()`
* `system()`
* `shell_exec()`
* `create_function()`
* `call_user_func_array()`
* `call_user_func()`
* `url_exec()`
* `passthru()`
* `Java()`
* `COM()`
* `event_new()`
* `dotnet_load()`
* `runkit_function_rename()`
* `pcntl_signal()`
* `pcntl_alarm()`
* `register_tick_function()`
* `dl()`
* `pfsockopen()`
* `fsockopen()`
* `posix_mkfifo()`
* `posix_getlogin()`
* `posix_ttyname()`
* `posix_kill()`
* `posix_mkfifo()`
* `posix_setpgid()`
* `posix_setsid()`
* `posix_setuid()`

The following functions and (super-) global variables MAY only be used in the phpOMS Framework in special cases.

* `$_GET`
* `$_POST`
* `$_PUT`
* `$_DELETE`
* `$_SERVER`
* `header()`
* `mail()`
* `phpinfo()`
* `getenv()`
* `get_current_user()`
* `proc_get_status()`
* `get_cfg_var()`
* `disk_free_space()`
* `disk_total_space()`
* `diskfreespace()`
* `getcwd()`
* `getlastmo()`
* `getmygid()`
* `getmyinode()`
* `getmypid()`
* `getmyuid()`
* `proc_nice()`
* `proc_terminate()`
* `proc_close()`
* `pfsockopen()`
* `fsockopen()`
* `apache_child_terminate()`
* `posix_kill()`
* `posix_mkfifo()`
* `posix_setpgid()`
* `posix_setsid()`
* `posix_setuid()`
* `ftp_get()`
* `ftp_nb_get()`
* `register_shutdown_function()`
* `chown()`
* `chdir()`
* `chmod()`
* `chgrp()`
* `symlink()`
* `flock()`
* `socket_create()`
* `socket_connect()`

The usage of the following functions SHOULD be avoided and inspected for any kind of possible injection.

* `include()`
* `include_once()`
* `require()`
* `require_once()`
* `fopen()`
* `delete()`
* `copy()`
* `file()`
* `file_get_contents()`
* `file_put_contents()`
* `readfile()`
* `rename()`
* `symlink()`
* `rmdir()`
* `mkdir()`
* `touch()`
* `unlink()`