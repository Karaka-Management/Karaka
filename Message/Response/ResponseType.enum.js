/**
 * Response type enum.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.Message.Response */
    jsOMS.Autoloader.defineNamespace('jsOMS.Message.Response');
    
    jsOMS.Message.Response.ResponseType = Object.freeze({
        TEXT: 'text',
        JSON: 'json',
        DOCUMENT: 'document',
        BLOB: 'blob',
        ARRAYBUFFER: 'arraybuffer',
        DEFAULT: ''
    });
}(window.jsOMS = window.jsOMS || {}));
