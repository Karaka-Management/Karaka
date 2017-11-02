/**
 * DrawType.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    /** @namespace jsOMS.Modules.Draw */
    jsOMS.Autoloader.defineNamespace('jsOMS.Modules.Draw');
    
    jsOMS.Modules.Draw.DrawTypeEnum = Object.freeze({
        DRAW: 0,
        LINE: 1,
        RECTANGLE: 2,
        CIRCLE: 3
    });
}(window.jsOMS = window.jsOMS || {}));
