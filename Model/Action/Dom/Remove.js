/**
 * Set message.
 *
 * @param {Object} action Action data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const removeButtonAction = function (action, callback, element)
{
    "use strict";

    const e = action.base === 'self' ? (action.selector === '' ? [element] : element.querySelectorAll(action.selector)) : document.querySelectorAll(action.selector);

    for(let i in e) {
        /** global: HTMLElement */
        if(!e.hasOwnProperty(i) || !e[i] || !(e[i] instanceof HTMLElement)) {
            continue;
        }

        if (typeof action.aniOut !== 'undefined') {
            e[i].classList.add(action.aniOut);
        }

        setTimeout(function ()
        {
            e[i].parentElement.removeChild(e[i]);

            const dim = document.getElementById('dim');

            if(dim) {
                document.getElementById('dim').classList.add('vh');
            }
        }, 200);
    }

    callback();
};
