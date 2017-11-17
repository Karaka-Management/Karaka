# Views

Views contain the raw information of a result which then depending on the template will be rendered. While it is possible to use the generic `View` class which provides the `addData()` `setData()` and `getData()` methods it is recommended to generate more specialized views for better variable handling as well as providing view logic. The template itself should not contain view logic and only representation logic. In some cases however it is required to modify/transform data which should be handled in the view.

## Implementation

A view must implement `\Serializable` and `\JsonSerializable`.

In case the response header is set to JSON the view will automatically get parsed as JSON object, either by using a the JSON template or by encoding the view. For the JSON serialization the `jsonSerialize()` function will be used in all other cases the `serialize()` function will be used.

## Localization

The base view class contains the request as well as the response objects hence it also contains the request/response localization. One of the most important methods is the `getText()` method. This private method allows for module and theme specific translations of defined language elements. 

In the template you can simply use `$this->getText({TEXT_ID})` for localized text. All other localization elements can be accessed in a similar way e.g. `$this->l11n->getTemperature()`.

In html templates it's recommended to use `$this->getHtml({TEXT_ID})` as this will savely escape defined strings for html output. In case you would like to escape none pre-defined language strings use `$this->printHtml('string to escape')`.

## Templates

Templates can be set with the `setTemplate()` method. It is important to note that templates MUST have the file ending `.tpl.php`. Other file endings are not supported.

```php
$view->setTemplate('/Modules/Test/Theme/Backend/template_file');
```

Note that the path definition doesn't include the file ending.

## Data Binding

In the generic view it's possible to bind data by using the `setData()` method and this data can be accessed by using the `getData()` method. 