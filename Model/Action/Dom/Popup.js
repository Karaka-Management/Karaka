/**
 * Set message.
 *
 * @param {Object} action Action data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const popupButtonAction = function (action, callback, element)
{
    "use strict";

    const popup = action.base === 'self' ? (action.selector === '' ? [element] : element.querySelectorAll(action.selector)) : document.querySelectorAll(action.selector);

    for(let i in popup) {
        /** global: HTMLElement */
        if(!popup.hasOwnProperty(i) || !popup[i] || !(popup[i] instanceof HTMLElement)) {
            continue;
        }

        const clone = document.importNode(popup[i].content, true);
        const dim = document.getElementById('dim');

        if(dim) {
            document.getElementById('dim').classList.remove('vh');
        }

        for(let j in clone) {
            if(!clone.hasOwnProperty(j) || !(clone[j] instanceof HTMLElement)) {
                continue;
            }

            clone[j].innerHTML = clone[j].innerHTML.replace(/\{\$id\}/g, action.id);
        }

        document.body.insertBefore(clone, document.body.firstChild);

        let e = document.getElementById(popup[i].id.substr(0, popup[i].id.length - 4));

        if(!e) {
            continue;
        }

        window.omsApp.uiManager.getActionManager().bind(e.querySelectorAll('[data-action]'));
        
        e.classList.add('animated');
        if (typeof action.aniIn !== 'undefined') {
            e.classList.add(action.aniIn);
        }

        if (action.stay > 0) {
            setTimeout(function ()
            {
                let out = 0;
                if (typeof action.aniOut !== 'undefined') {
                    e.classList.remove(action.aniIn);
                    e.classList.add(action.aniOut);
                    out = 200;
                }

                setTimeout(function ()
                {
                    if (typeof action.aniOut !== 'undefined') {
                        e.classList.add(action.aniOut);
                    }

                    e.parentElement.removeChild(e);

                    const dim = document.getElementById('dim');

                    if(dim) {
                        document.getElementById('dim').classList.add('vh');
                    }
                }, out);
            }, action.stay);
        }
    }

    callback();
};
