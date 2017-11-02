# Events

Events are available in the frontend and the backend. Both implementations provide the same functionality and are implemented in a similar way.

## Creating Events

Every event requires a unique trigger key as well as a `\Closure` which should be called once the event is triggered.

```
$this->eventManager->attach('eventId', function($data) { echo 'Hello World'; });
```

If an event should only be able to be triggered once another boolean parameter has to be edded to the `attach()` function call. 

```
$this->eventManager->attach('eventId', function($data) { echo 'Hello World'; }, true);
```

Now the event will be removed from the event manager once executed.

## Triggering Events

An event can be triggered by calling the `trigger()` function.

```
$this->eventManager->trigger('eventId');
```

## Multi Condition Events

In some cases it is required that multiple conditions are met before an event is supposed to be triggered. This can be achived by registering these conditions through the `addGroup()` function. 

```
$this->eventManager->addGroup('eventId', 'conditionName');
$this->eventManager->addGroup('eventId', 'conditionName2');
```

Now the event will only be triggered once every registered condition was triggered. If requried it's also possible to pass data to the event closure.

```
$data = [1, 2, new Object()];
$this->eventManager->trigger('eventId', 'conditionName', $data); // No output
$this->eventManager->trigger('eventId', 'conditionName2', $data); // Hello World
$this->eventManager->trigger('eventId'); // Hello World
$this->eventManager->trigger('eventId', 'conditionName'); // Hello World
```

The order in which these conditions are triggered doesn't mapper. A multi condition event SHOULD be atteched with the optional boolean parameter `true`. These events can only be executed once and will be removed afterwards. In case the optional boolean parameter was not set to `true` the event will remain in the event manager and will be triggered whenever `trigger('eventId')` is called.

Another optional boolean parameter can be added at the end if the event should stay active in the event manager but all trigger conditions should be reset after executed once. 