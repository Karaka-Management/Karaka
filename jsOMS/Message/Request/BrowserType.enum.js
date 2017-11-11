/**
 * Request data enum.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.Message.Request */
    jsOMS.Autoloader.defineNamespace('jsOMS.Message.Request');

    jsOMS.Message.Request.BrowserType = Object.freeze({
        OPERA: 'opera',
        FIREFOX: 'firefox',
        SAFARI: 'safari',
        IE: 'msie',
        EDGE: 'edge',
        CHROME: 'chrome',
        BLINK: 'blink',
        UNKNOWN: 'unknown'
    });
}(window.jsOMS = window.jsOMS || {}));
