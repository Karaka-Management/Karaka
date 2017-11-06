# Documentation

## Php

The php documentation is based on PhpDocumentor, therefore only valid PhpDocumentor comments are valid for files, classes, functions/methods and (member) variables.

### File

A file documentation MUST be implemented in the following form:

```
/**
 * File description
 *
 * PHP Version 7.0
 *
 * @category   Category name
 * @package    Package name
 * @author     Your Author 1 <your@email.com>
 * @author     Your Author 2 <your.second@email.com>
 * @copyright  Orange Management
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://your.url.com
 */
```

### Class

A class documentation MUST be implemented in the following form:

```
/**
 * Class description.
 *
 * @category   Category name
 * @package    Package name
 * @author     Your Author 1 <your@email.com>
 * @author     Your Author 2 <your.second@email.com>
 * @license    OMS License 1.0
 * @link       http://your.url.com
 * @since      1.0.0
 */
```

#### Member

A member variable documentation MUST be implemented in the following form:

```
/**
 * Member variable description.
 *
 * @var variable_type
 * @since 1.0.0
 */
```

#### Function/Method

A function/method documentation MUST be implemented in the following form:

```
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
 * @author Your Author 2 <your.second@email.com>
 */
```

### Variable

Variable documentation is not mandatory and can be omitted. However it's recommended to use a variable documentation for objects and arrays of objects in templates for ide code completion.

Example:

```
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

```
////
// Documentation
// 
// Optional example or more detailed description.
// 
// @since  1.0.0
// @author Your Author 2 <your.second@email.com>
////
```

### Class

#### Member

#### Function/Method

### Variable