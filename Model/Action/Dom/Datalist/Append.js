/**
 * Set message.
 *
 * @param {{title:string},{content:string},{level:int},{delay:int},{stay:int}} action Message data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const datalistAppend = function (action, callback, element)
{
    "use strict";

    const datalist = document.getElementById(action.id),
        dataLength = action.data.length;

    let option;

    for(let i = 0; i < dataLength; i++) {
        option = document.createElement('option');
        option.value = action.data[i][action.text];
        option.setAttribute('data-value', action.data[i][action.value]);
        datalist.appendChild(option);
    }
    
    callback();
};
