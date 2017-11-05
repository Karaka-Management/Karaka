/**
 * Validate Keypress.
 *
 * @param {Object} action Action data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const validateKeypress = function (action, callback, element)
{
    "use strict";

    const invertValidate = action.pressed.startsWith('!'),
        keyPressCheck = invertValidate ? action.pressed.split('!') : action.pressed.split('|');

    if((!invertValidate && keyPressCheck.indexOf(action.data.keyCode.toString()) !== -1) || (invertValidate && keyPressCheck.indexOf(action.data.keyCode.toString()) === -1)) {
        callback();
    }
};
