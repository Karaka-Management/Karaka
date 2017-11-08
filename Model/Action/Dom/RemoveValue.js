/**
 * Set message.
 *
 * @param {Object} action Action data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const domRemoveValue = function (action, callback, element)
{
    "use strict";

    const e = action.base === 'self' ? (action.selector === '' ? [element] : element.querySelectorAll(action.selector)) : document.querySelectorAll(action.selector);

    for(let i in e) {
        /** global: HTMLElement */
        if(!e.hasOwnProperty(i) || !(e[i] instanceof HTMLElement)) {
            continue;
        }
        
        if(e[i].value === action.data) {
            e[i].value = '';
        } else {
            e[i].value = e[i].value.replace(', ' + action.data + ',', ',');

            if(e[i].value[i].startsWith(action.data + ', ')) {
                e[i].value = e[i].value.substring((action.data + ', ').length);
            }

            if(e[i].value[i].endsWith(', ' + action.data)) {
                e[i].value = e[i].value.substring(0, e[i].value.length - (', ' + action.data).length);
            }
        }
    }

    callback();
};