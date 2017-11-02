/**
 * Collects data based on selectors
 */
const dataCollectionAction = function (action, callback)
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
