/**
 * Standard library
 *
 * This library provides useful functionalities for the DOM and other manipulations.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /**
     * Delayed watcher
     *
     * Used to fire event after delay
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.watcher = function ()
    {
        var timer = 0;
        return function (callback, ms)
        {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    }();

    /**
     * Merging two arrays recursively
     *
     * @param target Target array
     * @param source Source array
     *
     * @return Array
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.merge = function (target, source)
    {
        const out = jsOMS.clone(target);

        for (let p in source) {
            if (source.hasOwnProperty(p)) {
                // Property in destination object set; update its value.
                if (typeof source[p] === 'object') {
                    out[p] = jsOMS.merge(out[p], source[p]);

                } else {
                    out[p] = source[p];

                }
            } else {
                out[p] = source[p];
            }
        }

        return out;
    };

    /**
     * todo: implement deep clone/copy
     * @param obj
     * @returns {*}
     */
    jsOMS.clone = function (obj)
    {
        return obj;
    };
}(window.jsOMS = window.jsOMS || {}));
