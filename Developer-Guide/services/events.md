# Events

Events are available in the frontend and the backend. Both implementations provide the same functionality and are implemented in a similar way.

## Creating Events

Every event requires a unique trigger key as well as a `\Closure` which should be called once the event is triggered.

```php
$eventManager->attach('eventId', function() { echo 'Hello World'; });
```

### Repeating events

If a event should only be able to be triggered once another boolean parameter has to be edded to the `attach()` function call. 

```php
$eventManager->attach('eventId', function() { echo 'Hello World'; }, true);
```

Now the event will be removed from the event manager once executed. 

### Resetting events

In case an event should be reset (all conditions mut be met again befor it can be triggered) after it got successfully triggered  one more parameter can be added.

```php
$eventManager->attach('eventId', function() { echo 'Hello World'; }, false, true);
```

This only works if also the event **isn't** removed after triggering

## Triggering Events

An event can be triggered by calling the `trigger()` function.

```php
$eventManager->trigger('eventId');
```

## Multi Condition Events

In some cases it is required that multiple conditions are met before an event is supposed to be triggered. This can be achived by registering these conditions through the `addGroup()` function.

```php
$eventManager->addGroup('eventId', 'conditionName');
$eventManager->addGroup('eventId', 'conditionName2');
```

Now the event will only be triggered once every registered condition was triggered.

```php
$eventManager->trigger('eventId', 'conditionName'); // No output
$eventManager->trigger('eventId', 'conditionName2'); // Hello World
$eventManager->trigger('eventId'); // Hello World
$eventManager->trigger('eventId', 'conditionName'); // Hello World (if remove = false && reset = false)
$eventManager->trigger('eventId', 'conditionName'); // No output (if remove = false && reset = true)
$eventManager->trigger('eventId', 'conditionName'); // No output (if remove = true)
```

The order in which these conditions are triggered doesn't mapper. A multi condition event SHOULD be atteched with the optional boolean parameter `true`. These events can only be executed once and will be removed afterwards. In case the optional boolean parameter was not set to `true` the event will remain in the event manager and will be triggered whenever `trigger('eventId')` is called.