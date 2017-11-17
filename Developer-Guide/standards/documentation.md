# Documentation

## Php

The php documentation is based on PhpDocumentor, therefore only valid PhpDocumentor comments are valid for files, classes, functions/methods and (member) variables.

### File

A file documentation MUST be implemented in the following form:

```php
/**
 * File description
 *
 * PHP Version 7.0
 *
 * @category   Category name
 * @package    Package name
 * @copyright  Orange Management
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://your.url.com
 */
```

### Class

A class documentation MUST be implemented in the following form:

```php
/**
 * Class description.
 *
 * @category   Category name
 * @package    Package name
 * @license    OMS License 1.0
 * @link       http://your.url.com
 * @since      1.0.0
 */
```

#### Member

A member variable documentation MUST be implemented in the following form:

```php
/**
 * Member variable description.
 *
 * @var variable_type
 * @since 1.0.0
 */
```

#### Function/Method

A function/method documentation MUST be implemented in the following form:

```php
/**
 * Function/method description.
 *
 * Optional example or more detailed description.
 *
 * @param variable_type $param1Name Parameter description
 * @param variable_type $param2Name Parameter description
 *
 * @return return_type
 *
 * @since  1.0.0
 */
```

### Variable

Variable documentation is not mandatory and can be omitted. However it's recommended to use a variable documentation for objects and arrays of objects in templates for ide code completion.

Example:

```php
/** @var TestObject[] $myArray */
```

## JavaScript

The javascript documentation is based on JsDoc, therefore only valid JsDoc comments are valid for all js files.

### File

### Class

#### Member

#### Function/Method

### Variable

## Scss

The scss documentation is based on SassDoc, therefore only valid SassDoc comments are valid for all scss files.

### File

```js
/**
 * File description
 *
 * @category   Category name
 * @package    Package name
 * @copyright  Orange Management
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://your.url.com
 */
```

### Class

A class documentation MUST be implemented in the following form:

```js
/**
 * Class description.
 *
 * @category   Category name
 * @package    Package name
 * @license    OMS License 1.0
 * @link       http://your.url.com
 * @since      1.0.0
 */
```

#### Member

#### Function/Method

A function/method documentation MUST be implemented in the following form:

```js
/**
 * Function/method description.
 *
 * Optional example or more detailed description.
 *
 * @param {variable_type} param1Name Parameter description
 * @param {variable_type} [optionalPara] Parameter description
 *
 * @return {return_type}
 *
 * @since  1.0.0
 */
```

### Variable