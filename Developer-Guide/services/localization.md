# Localization

Most of the localization is stored inside the localization object which is part of every request and response as well as the account model.

## Language

Language specific text can be used through the `LocalizationManager`, either by directly calling the `getText()` function of the localization manager

```
$this->l11nManager->getHtml({LANGUAGE}, {MODULE}, {THEME}, {TEXT})
```

or indirectly by calling the `getText()` in the view context.

```
$this->getHtml({TEXT})
```

The language that should be used for a response should always be depending on the requested language and therefore never be hard coded.

The language code of the localization object is the 2 character ISO639 code. The corresponding enums are located in the localization directory and labeled with `ISO639`.

* ISO639Enum Language name
* ISO639x1Enum 2 character language code
* ISO639x2Enum 3 character language code

## Country

The country code of the localization object is the 2 character ISO3166 code. The corresponding enums are located in the localization directory and labeled with `ISO3166`.

* ISO3166TwoEnum 2 character country code
* ISO3166CharEnum 3 character country code
* ISO3166NameEnum country name
* ISO3166NumEnum country code

## Units

### Currency

The currency code of the localization object is the 3 character ISO4217 code. The corresponding enums are located in the localization directory and labeled with `ISO4217`.

* ISO4217CharEnum 3 character currency code
* ISO4217DecimalEnum currency decimal places
* ISO4217Enum currency name
* ISO4217NumEnum currency code
* ISO4217SubUnitEnum currency sub unit
* ISO4217SymbolEnum currency symbol

## Formatting

### Currency

The currency symbol can be placed either in front or at the end of a value. The `Money` class provides a function called `getCurrency()` which returns a localized representation by specifying the thousands and decimal separator as well as the currency symbol and its position.

```
$money->getCurrency(2, ',', '.', '$', 0);
```

### DateTime

The date/time is versatile and can have multiple formats. By default the localization object stores 5 different date/time formats depending on the degree of accuracy required. 

* very_short
* short
* medium
* long
* very_long

Other formats are beyond the scope of the localization and must be hard coded. Please be cautios when to hard code the formatting and pay attention to potential confusion for different localizations.

In the database only the ISO 8601 format will be used.

### Numeric

The numeric formatting is defined by a `thousands` and `decimal` separator and available as separate member variables of the localization object.