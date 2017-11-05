const showAction = function (action, callback)
{
    "use strict";

    const show = document.getElementById(action.id);

    if(!show) {
        return;
    }

    jsOMS.removeClass(show, 'vh');

    callback();
};