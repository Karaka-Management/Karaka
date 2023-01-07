import { NotificationLevel }   from '../../../../jsOMS/Message/Notification/NotificationLevel.js';
import { NotificationMessage } from '../../../../jsOMS/Message/Notification/NotificationMessage.js';
import { NotificationType }    from '../../../../jsOMS/Message/Notification/NotificationType.js';

/** global: jsOMS */
export const DEFAULT_EVENTS = {
    onStateChange: function (evt) {
        if (window.omsApp) {
            window.omsApp.state.hasChanges = true;
        }
    },

    onBeforeUnload: function (evt = null) {
        if (window.omsApp && window.omsApp.state.hasChanges) {
            // Cancel the event as stated by the standard.
            evt.preventDefault();

            // Chrome requires returnValue to be set.
            evt.returnValue = '';

            // firefox requires this to be removed
            delete evt.returnValue;

            let message = new NotificationMessage(NotificationLevel.WARNING, 'Unsaved changes', 'Do you want to continue?', true, true);
            message.primaryButton = {
                text: 'Yes',
                style: 'ok',
                callback: function () {
                    window.omsApp.state.hasChanges = false;

                    if (evt && evt.target) {
                        evt.target.dispatchEvent(evt);
                    }
                },
            };
            message.secondaryButton = {
                text: 'No',
                style: 'error',
                callback: function () {},
            };

            window.omsApp.notifyManager.send(message, NotificationType.APP_NOTIFICATION);
        }
    },
}
