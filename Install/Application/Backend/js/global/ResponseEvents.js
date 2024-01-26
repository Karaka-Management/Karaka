import { notifyMessage } from '../../../../../jsOMS/Model/Message/Notify.js';
import { formValidationMessage } from '../../../../../jsOMS/Model/Message/FormValidation.js';
import { redirectMessage } from '../../../../../jsOMS/Model/Action/Dom/Redirect.js';
import { reloadButtonAction } from '../../../../../jsOMS/Model/Action/Dom/Reload.js';

/** global: jsOMS */
export const RESPONSE_EVENTS = {
    'notify': notifyMessage, /** global: notifyMessage */
    'validation': formValidationMessage, /** global: formValidationMessage */
    'redirect': redirectMessage, /** global: redirectMessage */
    'reload': reloadButtonAction /** global: reloadButtonAction */
};
