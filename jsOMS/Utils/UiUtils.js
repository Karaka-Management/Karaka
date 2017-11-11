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
     * Class finder
     *
     * Checking if a element has a class
     *
     * @param {Object} ele DOM Element
     * @param {string} cls Class to find
     *
     * @return {boolean}
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.hasClass = function (ele, cls)
    {
        return typeof ele !== 'undefined' && ele !== null && typeof ele.className !== 'undefined' && ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
    };

    /**
     * Add class
     *
     * Adding a class to an element
     *
     * @param ele DOM Element
     * @param cls Class to add
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.addClass = function (ele, cls)
    {
        if (!jsOMS.hasClass(ele, cls)) {
            ele.className += " " + cls;
        }
    };

    /**
     * Remove class
     *
     * Removing a class form an element
     *
     * @param ele DOM Element
     * @param cls Class to remove
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.removeClass = function (ele, cls)
    {
        if (jsOMS.hasClass(ele, cls)) {
            const reg       = new RegExp('(\\s|^)' + cls + '(\\s|$)');
            ele.className = ele.className.replace(reg, '');
        }
    };

    /**
     * Action prevent
     *
     * Preventing event from firering and passing through
     *
     * @param event Event Event to stop
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.preventAll = function (event)
    {
        if (event.stopPropagation) {
            event.stopPropagation();
        } else {
            event.cancelBubble = true;
        }

        event.preventDefault();
    };

    /**
     * Ready invoke
     *
     * Invoking a function after page load
     *
     * @param func Callback function
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.ready = function (func)
    {
        // TODO: IE problems? + Maybe interactive + loaded can cause problems since elements might not be loaded yet?!!?!!?!
        if (document.readyState === 'complete' || document.readyState === 'loaded' || document.readyState === 'interactive') {
            func();
        } else {
            document.addEventListener("DOMContentLoaded", function (event)
            {
                func();
            });
        }
    };

    /**
     * Empty element
     *
     * Deleting content from element
     *
     * @param ele DOM Element
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.empty = function (ele)
    {
        while (ele.firstChild) {
            ele.removeChild(ele.firstChild);
        }
    };

    /**
     * Check node
     *
     * Checking if a selection is a node
     *
     * @param ele DOM Node
     *
     * @return {boolean}
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.isNode = function (ele)
    {
        /** global: Node */
        return (
            typeof Node === "object" ? ele instanceof Node :
            ele && typeof ele === "object" && typeof ele.nodeType === "number" && typeof ele.nodeName === "string"
        );
    };

    /**
     * Check element
     *
     * Checking if a selection is a element
     *
     * @param o DOM Element
     *
     * @return {boolean}
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.isElement = function (o)
    {
        /** global: HTMLElement */
        return (
            typeof HTMLElement === "object" ? o instanceof HTMLElement : o && typeof o === "object" && o !== null && o.nodeType === 1 && typeof o.nodeName === "string"
        );
    };

    /**
     * Getting element by class
     *
     * Getting a element by class in the first level
     *
     * @param ele DOM Element
     * @param cls Class to find
     *
     * @return Element
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.getByClass = function (ele, cls)
    {
        const length = ele.childNodes.length;

        for (let i = 0; i < length; i++) {
            if (jsOMS.hasClass(ele.childNodes[i], cls)) {
                return ele.childNodes[i];
            }
        }

        return null;
    };

    /**
     * Adding event listener to multiple elements
     *
     * @param e DOM Elements
     * @param {string} event Event name
     * @param {function} callback Event callback
     *
     * @function
     *
     * @since  1.0.0
     */
    jsOMS.addEventListenerToAll = function (e, event, callback)
    {
        const length = e.length;

        for (let i = 0; i < length; i++) {
            e[i].addEventListener(event, callback);
        }
    };
}(window.jsOMS = window.jsOMS || {}));
