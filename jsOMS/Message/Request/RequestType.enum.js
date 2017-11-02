/**
 * Request type enum.
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
    
    jsOMS.Message.Request.RequestType = Object.freeze({
        JSON: 'json',
        RAW: 'raw'
    });
}(window.jsOMS = window.jsOMS || {}));
