/**
 * Set message.
 *
 * @param {{title:string},{content:string},{level:int},{delay:int},{stay:int}} action Message data
 * @param {function} callback Callback
 *
 * @since 1.0.0
 */
const tableClear = function (action, callback, data)
{
    "use strict";

    const e = document.getElementById(action.id).getElementsByTagName('tbody')[0];

    while(e.firstChild) {
        e.removeChild(e.firstChild);
    }

    callback();
};
