# Money

Money is a delicate element and must be handled precisely. With the `Money` class a precise representation of float up to the precision of 4 decimal places is supported.

## Initialization

The initialization can be done by providing an integer, float or string representation. The following list describes how different scalar types get converted.

* (int) 12300   = 1.23
* (float) 1.23  = 1.23
* (string) 1.23 = 1.23

The max and min money values that can be represented on a 32bit system are `214,748.3647` and `-214,748.3647` which is most of the time not sufficient. On 64bit systems however the max and min values that can be represented ar `922,337,203,685,477.5807` and `-922,337,203,685,477.5807`.

## Operations

The `Money` class follows the builder pattern. The provided operations are addition, subtraction, multiplication, division, absolute and power.

## Example

```php
$money = new Money(1234567, ',', '.', '$', 0);
$money->add(1.0)->sub(10000)->mult('-1.0')->div(new Money(-1.0));
echo $money->getCurrency(); // $123.46
```
