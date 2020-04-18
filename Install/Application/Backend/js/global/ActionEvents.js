import { redirectMessage } from '../../../../jsOMS/Model/Message/Redirect.js';
import { requestAction } from '../../../../jsOMS/Model/Action/Message/Request.js';
import { reloadButtonAction } from '../../../../jsOMS/Model/Action/Dom/Reload.js';
import { preventEvent } from '../../../../jsOMS/Model/Action/Event/Prevent.js';
import { domClickAction } from '../../../../jsOMS/Model/Action/Dom/Click.js';
import { formSubmitAction } from '../../../../jsOMS/Model/Action/Dom/FormSubmit.js';

export const ACTION_EVENTS = {
    'redirect': redirectMessage, /** global: redirectMessage */
    'message.request': requestAction, /** global: requestAction */
    'dom.reload': reloadButtonAction, /** global: reloadButtonAction */
    'dom.click': domClickAction, /** global: domClickAction */
    'form.submit': formSubmitAction, /** global: domClickAction */
    'event.prevent': preventEvent, /** global: preventEvent */
};