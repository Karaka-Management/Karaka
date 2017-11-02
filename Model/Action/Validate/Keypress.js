/**
 * Validate Keypress.
 *
 * @param {{title:string},{content:string},{level:int},{delay:int},{stay:int}} action Message data
 * @param {function} callback Callback
 *
 * @since 1.0.0
 */
const validateKeypress = function (action, callback, data)
{
    "use strict";

    const invertValidate = action.pressed.startsWith('!'),
        keyPressCheck = invertValidate ? action.pressed.split('!') : action.pressed.split('|');

    if((!invertValidate && keyPressCheck.indexOf(action.data.keyCode.toString()) !== -1) || (invertValidate && keyPressCheck.indexOf(action.data.keyCode.toString()) === -1)) {
        callback();
    }
};
