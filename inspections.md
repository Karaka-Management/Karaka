# Inspections

Code inspections are very important in order to maintain the same code quality throughout the application. The Build repository contains all esential configuration files for the respective inspection tools. Every provided module will be evaluated based on the predefined code and quality standards. Only modules that pass all code, quality and unit tests are accepted. This also applies to updates and bug fixes. Any change will have to be re-evaluated.

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL" in this document are to be interpreted as described in RFC 2119.

## Class Constants, Properties, and Methods

The term "class" refers to all classes, interfaces, and traits.

## Code Quality

### General

### Modules

#### Langauge Files

Every provided language element in the language files SHOULD be used at least once by the module itself. 

## Code Standards

### Html

#### Indention

The default indention MUST be 4 spaces.

#### Omitted closing tags

The following closing tags SHOULD be omitted:

* `</li>`
* `</option>`
* `</tr>`
* `</td>`
* `</th>`
* `</thead>`
* `</tbody>`
* `</tfoot>`
* `</head>`
* `</body>`
* `</html>`

The following tags MUST not specify a end tag (\):

* `<br \>`
* `<meta \>`
* `<input \>`
* `<hr \>`
* `<img \>`
* `<link \>`
* `<source \>`
* `<embed \>`

### Php

The php code needs to be php 7 compliant. No php 7 deprecated or removed elements, functions or practices are allowed (e.g. short open tag).

####  Php Tags

PHP code MUST use the long `<?php ?>` tags or the short-echo `<?= ?>` tags; it MUST NOT use the other tag variations.

#### Character Encoding

PHP code MUST use only UTF-8 without BOM

#### Indention

The default indention MUST be 4 spaces.

#### Side Effects

A file SHOULD declare new symbols (classes, functions, constants, etc.) and cause no other side effects, or it SHOULD execute logic with side effects, but SHOULD NOT do both.

The phrase "side effects" means execution of logic not directly related to declaring classes, functions, constants, etc., merely from including the file.

"Side effects" include but are not limited to: generating output, explicit use of require or include, connecting to external services, modifying ini settings, emitting errors or exceptions, modifying global or static variables, reading from or writing to a file, and so on.

#### Namespace and Class Names

Namespaces and classes MUST follow an "autoloading" PSR: [PSR-0, PSR-4].

This means each class is in a file by itself, and is in a namespace of at least one level: a top-level vendor name.

Class names MUST be declared in StudlyCaps.

#### Constants

Class constants MUST be declared in all upper case with underscore separators.

#### Methods

Method names MUST be declared in camelCase().

#### Php in html

Php code embedded into template files SHOULD use the alternative syntax for control structures in order to improve the readability:

```
if($a === 5) : ?>
    <p>This is html</p>
<?php endif; ?>
```

### JavaScript

#### Indention

The default indention MUST be 4 spaces.

### Scss

#### Indention

The default indention MUST be 4 spaces.

## Code Security

