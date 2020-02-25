import { redirectMessage } from '../../../../jsOMS/Model/Message/Redirect.js';
import { requestAction } from '../../../../jsOMS/Model/Action/Message/Request.js';
import { reloadButtonAction } from '../../../../jsOMS/Model/Action/Dom/Reload.js';
import { preventEvent } from '../../../../jsOMS/Model/Action/Event/Prevent.js';

export const ACTION_EVENTS = {
    'redirect': redirectMessage, /** global: redirectMessage */
    'message.request': requestAction, /** global: requestAction */
    'dom.reload': reloadButtonAction, /** global: reloadButtonAction */
    'event.prevent': preventEvent, /** global: preventEvent */
};