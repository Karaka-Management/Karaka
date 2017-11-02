/**
 * Click type.
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

    jsOMS.UI.Input.Mouse.ClickType = Object.freeze({
        LEFT: 0,
        MIDDLE: 1,
        RIGHT: 2
    });
}(window.jsOMS = window.jsOMS || {}));
