/**
 * Browser notification.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.Message.Notification */
    jsOMS.Autoloader.defineNamespace('jsOMS.Message.Notification');

    jsOMS.Message.Notification.NotificationManager = function()
    {
        this.appNotifier = new jsOMS.Message.Notification.App.AppNotification();
        this.browserNotifier = new jsOMS.Message.Notification.Browser.BrowserNotification();
    };

    jsOMS.Message.Notification.NotificationManager.prototype.send = function(message, type)
    {
        if(jsOMS.Message.Notification.NotificationType.APP_NOTIFICATION === type) {
            this.appNotifier.send(message);
        } else {
            this.browserNotifier.send(message);
        }
    };

    jsOMS.Message.Notification.NotificationManager.prototype.getAppNotifier = function()
    {
        return this.appNotifier;
    };

    jsOMS.Message.Notification.NotificationManager.prototype.getBrowserNotifier = function()
    {
        return this.browserNotifier;
    };
}(window.jsOMS = window.jsOMS || {}));