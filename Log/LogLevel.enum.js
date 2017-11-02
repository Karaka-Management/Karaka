/**
 * Log Level enum.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.Log */
    jsOMS.Autoloader.defineNamespace('jsOMS.Log');

    jsOMS.Log.LogLevel = Object.freeze({
        EMERGENCY: 'emergency',
        ALERT: 'alert',
        CRITICAL: 'critical',
        ERROR: 'error',
        WARNING: 'warning',
        NOTICE: 'notice',
        INFO: 'info',
        DEBUG: 'debug'
    });
}(window.jsOMS = window.jsOMS || {}));
