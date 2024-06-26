import { redirectMessage } from '../../../../../jsOMS/Model/Action/Dom/Redirect.js';
import { requestAction } from '../../../../../jsOMS/Model/Action/Message/Request.js';
import { reloadButtonAction } from '../../../../../jsOMS/Model/Action/Dom/Reload.js';
import { preventEvent } from '../../../../../jsOMS/Model/Action/Event/Prevent.js';
import { jumpAction } from '../../../../../jsOMS/Model/Action/Event/Jump.js';
import { ifAction } from '../../../../../jsOMS/Model/Action/Event/If.js';
import { domClickAction } from '../../../../../jsOMS/Model/Action/Dom/Click.js';
import { domGetValue } from '../../../../../jsOMS/Model/Action/Dom/GetValue.js';
import { domSetValue } from '../../../../../jsOMS/Model/Action/Dom/SetValue.js';
import { domChangeAttribute } from '../../../../../jsOMS/Model/Action/Dom/ChangeAttribute.js';
import { formSubmitAction } from '../../../../../jsOMS/Model/Action/Dom/FormSubmit.js';

export const ACTION_EVENTS = {
    'redirect': redirectMessage, /** global: redirectMessage */
    'message.request': requestAction, /** global: requestAction */
    'dom.reload': reloadButtonAction, /** global: reloadButtonAction */
    'dom.click': domClickAction, /** global: domClickAction */
    'form.submit': formSubmitAction, /** global: domClickAction */
    'event.prevent': preventEvent, /** global: preventEvent */
    'dom.get': domGetValue, /** global: domGetValue */
    'dom.set': domSetValue, /** global: domSetValue */
    'dom.attr.change': domChangeAttribute, /** global: domChangeAttribute */
    'jump': jumpAction, /** global: jumpAction */
    'if': ifAction, /** global: ifAction */
};
