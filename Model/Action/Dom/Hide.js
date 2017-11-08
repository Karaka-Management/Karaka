const hideAction = function (action, callback)
{
    "use strict";

    const hide = document.getElementById(action.id);

    if(!hide) {
        return;
    }

    /** global: jsOMS */
    jsOMS.addClass(hide, 'vh');

    callback();
};