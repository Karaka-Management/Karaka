/**
 * App notification.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.Message.Notification.App */
    jsOMS.Autoloader.defineNamespace('jsOMS.Message.Notification.App');

    jsOMS.Message.Notification.App.AppNotification = function()
    {
        this.status = 0;
    };

    jsOMS.Message.Notification.App.AppNotification.prototype.setStatus = function(status)
    {
        this.status = status;
    }

    jsOMS.Message.Notification.App.AppNotification.prototype.requestPermission = function()
    {
        const self = this;
    };

    jsOMS.Message.Notification.App.AppNotification.prototype.send = function(msg)
    {
    };
}(window.jsOMS = window.jsOMS || {}));