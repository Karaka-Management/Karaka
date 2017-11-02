# Action Manager

The action manager is only available for the frontend as its purpose is to execute/trigger events based on UI events. The action manager allows to define procedures for UI events without writing any inline JavaScript and reducing the necessary JavaScript code in general thanks to this modular approach.

## Binding Action Events

In order to perform actions on UI events it is necessary to define listeners for elements that need to be observed. Usually these elements are input and button elements. The following action has one `click-listener` executing the defined actions if this listener is triggered.

```
<button data-action='[
    {
        "listener": click, "action": [...]
    }
]'>
```

Now we have to define the actions that should be executed when a click-event is performed.

```
<button data-action='[
    {
        "listener": "click", "action": [
            {"key": 1, "type": "dom.popup", "tpl": "some-tpl", "aniIn": "fadeIn"},
            {"key": 2, "type": "message.request", "uri": "http://api.uri.com/?para=123", , "method": "GET", "request_type": "json"},
            {"key": 3, "type": "dom.table.append", "id": "some-tpl", "aniIn": "fadeIn", "data": [], "bindings": {"id": "id", "name": "name/0"}, "position": -1}
        ]
    }
]'>
```

Actions can be executed synchronously or asynchronously depending on the actions implementation. Every action needs a `key` which has to be unique locally for this listner. Also every action needs a type; the type is used to identify which code to execute if the action is triggered. The framework comes with a set of pre-defined actions that can be used. All other object properties depend on the action.

In the example above, if the button is clicked it will look for a template with the id `some-tpl` and insert it into the DOM with a fade-in animation effect. Afterwards a GET request is performed to the API. The resultset of the API is then appended to a table in the previously opened popup. The binding in this example are used to map the API resultset to the table columns.

The API request URI doesn't have to be static but could be dynamic by using the URI factory which would allow to fetch values from other input fields as parameter value etc.

### Child Elements

In some situations it is required to define listeners and actions for all child elements. Writing listeners and action for every list element for example is tedious and confusing. For this purpose the parent element can specify a selector for a listener.

```
<ul id="click-list" data-action='[
    {
        "listener": "...", "selector": "#click-list li", "action": [...]
    }
]'>
    <li>...
    <li>...
</ul>
```

This registers the same listener to all `<li>` elements. Another advantag is that in case a new `<li>` element gets added it will automatically also receive this listener.

## Defining Actions

### Definition

A action event skeleton looks as follows:

```
const uniqueFunctionName = function(action, callback, data)
{
    "use strict";

    // some code here

    callback(newData);
};
```

The action parameter contains all the action configuration values, the callback is the next action event that should be triggered afterwards and the data parameter is either data that is passed from a previous action event or data you would like to pass to the next action event.

### Binding

A action event can be registered simply by adding it to the action manager:

```
this.uiManager.getActionManager().add('some.new.action', uniqueFunctionName);
```