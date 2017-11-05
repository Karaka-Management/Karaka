/**
 * Set message.
 *
 * @param {Object} action Action data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const domGetValue = function (action, callback, element)
{
    "use strict";

    const e = action.base === 'self' ? (action.selector === '' ? [element] : element.querySelectorAll(action.selector)) : document.querySelectorAll(action.selector);

    for(let i in e) {
        if(!(e[i] instanceof HTMLElement)) {
            continue;
        }
        
        let value = '';

        if(e[i].tagName === 'INPUT' || e[i].tagName === 'SELECTS') {
            value = e[i].value;
        } else {
            value = e[i].getAttribute('data-id');
        }

        callback(value);
    }
};