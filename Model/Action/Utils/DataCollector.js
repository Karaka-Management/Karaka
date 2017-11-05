/**
 * Collect data.
 *
 * @param {Object} action Action data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const dataCollectionAction = function (action, callback, element)
{
    "use strict";
    
    let elements, data = {};

    for(let selector in action.collect) {
        elements = document.querySelectorAll(action.collect[selector]);

        for(let e in elements) {
            // todo: different types of elements have differnt forms of storing values (input, textarea etc.)
            data[selector].push(e.value);
        }
    }

    callback(data);
};
