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

    /** @namespace jsOMS.Message.Notification.Browser */
    jsOMS.Autoloader.defineNamespace('jsOMS.Message.Notification.Browser');

    jsOMS.Message.Notification.Browser.BrowserNotification = function()
    {
        this.status = 0;
    };

    jsOMS.Message.Notification.Browser.BrowserNotification.prototype.setStatus = function(status)
    {
        this.status = status;
    };

    jsOMS.Message.Notification.Browser.BrowserNotification.prototype.requestPermission = function()
    {
        const self = this;

        /** global: Notification */
        if(Notification.permission !== 'granted' && Notification.permission !== 'denied') {
            Notification.requestPermission(function(permission) {
                if(permission === 'granted') {
                    let msg = new jsOMS.Message.Notification.NotificationMessage();

                    self.send(msg);
                }
            });
        }
    };

    jsOMS.Message.Notification.Browser.BrowserNotification.prototype.send = function(msg)
    {
        /** global: Notification */
        let n = new Notification(/* ... */);
    };
}(window.jsOMS = window.jsOMS || {}));