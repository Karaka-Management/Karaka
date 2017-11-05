const hideAction = function (action, callback)
{
    "use strict";

    const hide = document.getElementById(action.id);

    if(!hide) {
        return;
    }

    jsOMS.addClass(hide, 'vh');

    callback();
};