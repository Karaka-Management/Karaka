import { Logger }              from '../../../../jsOMS/Log/Logger.js';
import { NotificationLevel }   from '../../../../jsOMS/Message/Notification/NotificationLevel.js';
import { NotificationMessage } from '../../../../jsOMS/Message/Notification/NotificationMessage.js';
import { NotificationType }    from '../../../../jsOMS/Message/Notification/NotificationType.js';
import { Request }             from '../../../../jsOMS/Message/Request/Request.js';
import { RequestMethod }       from '../../../../jsOMS/Message/Request/RequestMethod.js';
import { RequestType }         from '../../../../jsOMS/Message/Request/RequestType.js';
import { Response }            from '../../../../jsOMS/Message/Response/Response.js';

/** global: jsOMS */
export const VOICE_EVENTS = {
    'read': 'read_text',
    'help': function() { Logger.instance.debug('There is no help for you.'); },
    'go to': function(speech) {
        const request = new Request();
        request.setData({});
        request.setType(RequestType.FORM_DATA);
        request.setUri('api/search?app=Backend&search=:goto+' + speech);
        request.setMethod(RequestMethod.GET);
        request.setSuccess(function (xhr)
        {
            console.log(xhr.response);

            try {
                const o      = JSON.parse(xhr.response)[0],
                    response = new Response(o);

                if (typeof response.get('type') !== 'undefined') {
                    window.omsApp.responseManager.run(response.get('type'), response.get(), request);
                } else if (typeof o.status !== 'undefined' && o.status !== NotificationLevel.HIDDEN) {
                    window.omsApp.notifyManager.send(
                        new NotificationMessage(o.status, o.title, o.message), NotificationType.APP_NOTIFICATION
                    );
                }
            } catch (e) {
                console.log(e);

                Logger.instance.error('Invalid form response. \n'
                    + 'Request: ' + JSON.stringify(speech) + '\n'
                    + 'Response: ' + xhr.response
                );
            }
        });

        request.setResultCallback(0, function (xhr)
        {
            window.omsApp.notifyManager.send(
                new NotificationMessage(
                    NotificationLevel.ERROR,
                    'Failure',
                    'Some failure happened'
                ), NotificationType.APP_NOTIFICATION
            );
        });

        request.send();
     },
};