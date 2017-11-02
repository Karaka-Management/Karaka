/**
 * Event type.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.UI.Input.Mouse */
    jsOMS.Autoloader.defineNamespace('jsOMS.UI.Input.Mouse');

    jsOMS.UI.Input.Mouse.EventType = Object.freeze({
        CONTEXT: 0,
        LONGPRESS: 1,
        CLICK: 2
    });
}(window.jsOMS = window.jsOMS || {}));
