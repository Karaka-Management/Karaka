/**
 * Response manager class.
 *
 * Used for auto handling different responses.
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

    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.Message.Response.ResponseManager = function ()
    {
        this.messages = {};
    };

    /**
     * Add response handler.
     *
     * This allows the response handler to generally handle responses and also handle specific requests if defined.
     *
     * @param {string} key Response key
     * @param {requestCallback} message Callback for message
     * @param {string} [request] Request id in order to only handle a specific request
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Message.Response.ResponseManager.prototype.add = function (key, message, request)
    {
        request = typeof request !== 'undefined' ? request : 'any';
        if (typeof this.messages[key] === 'undefined') {
            this.messages[key] = [];
        }

        this.messages[key][request] = message;
    };

    /**
     * Execute a predefined callback.
     *
     * Tries to execute a request specific callback or otherwise a general callback if defined.
     *
     * @param {string} key Response key
     * @param {Array|Object} data Date to use in callback
     * @param {jsOMS.Message.Request.Request} [request] Request id for request specific execution
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Message.Response.ResponseManager.prototype.run = function (key, data, request)
    {
        if (typeof request !== 'undefined' && typeof this.messages[key] !== 'undefined' && typeof this.messages[key][request] !== 'undefined') {
            this.messages[key][request](data);
        } else if (typeof this.messages[key] !== 'undefined') {
            this.messages[key].any(data);
        } else {
            jsOMS.Log.Logger.instance.warning('Undefined type: ' + key);
        }
    };
}(window.jsOMS = window.jsOMS || {}));
