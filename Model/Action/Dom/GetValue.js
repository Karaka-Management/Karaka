/**
 * Set message.
 *
 * @param {{title:string},{content:string},{level:int},{delay:int},{stay:int}} action Message data
 * @param {function} callback Callback
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