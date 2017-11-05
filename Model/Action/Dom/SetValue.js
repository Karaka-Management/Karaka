/**
 * Set message.
 *
 * @param {Object} action Action data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const domSetValue = function (action, callback, element)
{
    "use strict";

    let dataPath = action['value'],
        path = '',
        tempDataValue = '',
        values = [],
        replaceText = '';
    let start = 0, end = 0;
    
    while((start = dataPath.indexOf('{', start)) !== -1) {
        end = dataPath.indexOf('}', start);
        start++;

        path = dataPath.substring(start, end);
        tempDataValue = jsOMS.getArray(path, action.data, '/');

        replaceText = '{' + path + '}';
        dataPath = dataPath.replace(new RegExp(replaceText.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), tempDataValue);
    }

    const fill = action.base === 'self' ? (action.selector === '' ? [element] : element.querySelectorAll(action.selector)) : document.querySelectorAll(action.selector);

    for(let i in fill) {
        if(!(fill[i] instanceof HTMLElement)) {
            continue;
        }

        if(fill[i].tagName.toLowerCase() === 'div' || fill[i].tagName.toLowerCase() === 'span') {
            if(action.overwrite) {
                fill[i].innerHTML = dataPath;
            } else {
                fill[i].innerHTML += (fill[i].innerHTML !== '' ? '' : '') + dataPath;
            }
        } else {
            if(action.overwrite) {
                fill[i].value = dataPath;
            } else {
                fill[i].value += (fill[i].value !== '' ? ', ' : '') + dataPath;
            }
        }
    }

    callback(action.data);
};