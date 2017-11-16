# Code Standards

The term "class" refers to all classes, interfaces, and traits. These standards only show how the code should look like and doesn't give examples of bad code.

## Side Effects

A file SHOULD declare new symbols (classes, functions, constants, etc.) and cause no other side effects, or it SHOULD execute logic with side effects, but SHOULD NOT do both.

The phrase "side effects" means execution of logic not directly related to declaring classes, functions, constants, etc., merely from including the file.

"Side effects" include but are not limited to: generating output, explicit use of require or include, connecting to external services, modifying ini settings, emitting errors or exceptions, modifying global or static variables, reading from or writing to a file, and so on.

## Array

Arrays should always bet initialized by using `[]`.

```php
$arr = [1, 2, 3];
```

## Indention

The default indention MUST be 4 spaces.

## Spacing

### Enumerations

Always use a whitespace **after**:

* `,`
* `;` (unless at the end of a line)

### Operators

Always use a whitespace **before** and **after**:

* assignment (e.g. `=`, `=>`, `+=`, `/=`, `*=`, `-=`, `.=`)
* math operations (e.g. `+`, `-`, `*`, `/`, `%`, `&`, `|`, `**`, `>>`, `<<`) 
* logic operators (e.g. `&&`, `||`)
* comparison (e.g. `==`, `===`, `>`, `>=`, `<`, `<=`)

### Other

Never use spaces between variables and atomic operations (e.g. `!`, `++`, `--`)

### Parentheses

Don't use whitespace inside ANY parentheses (e.g. functions, loops, conditions, catch, closures).

```js
for (let i = 1; i < 100; i++) { ... }
``` 

```js
function(para1, para2) { ... }
``` 

### Brackets

Don't use whitespace inside ANY brackets.

```php
$arr = [1, 2, 3];
```

### Braces

Always use a whitespace between braces and keywords (e.g. else, while, catch, finally) and parentheses

```php
try {

} catch (...);
```

```php
if (...) {

} else (...);
```

Braces are on the same line as the previous or following keyword except in classes and functions.

```php
function()
{

}
```

```php
class Test
{

}
```

### If, while, for, foreach, switch

Always use a whitespace before the parentheses.

```php
while (true) { ... }
``` 

## If, while, for, foreach, switch

Always use braces even for potential one liners. The only exception is the ternary operator.

```php
if (...) {

}
```

```php
$result = condition ? expr1 : expr2;
```

## Constants

Constants must be written with capital letters and snake case.

```js
CONSTANT_TEST = true;
```

## Variables

Variables must be written in camel case.

### Boolean variables

Boolean variable names should start with a boolean expression (e.g. is, has)

## Quotation

All string representations should use single quotes `''`.

```js
'This is a string'
```