const focusAction = function (action, callback)
{
    "use strict";

    const focus = document.getElementById(action.id);

    if(!focus) {
        return;
    }

    focus.focus();

    callback();
};