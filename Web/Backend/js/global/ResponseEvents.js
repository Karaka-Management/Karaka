import { notifyMessage } from '../../../../jsOMS/Model/Message/Notify.js';
import { formValidationMessage } from '../../../../jsOMS/Model/Message/FormValidation.js';
import { redirectMessage } from '../../../../jsOMS/Model/Message/Redirect.js';
import { reloadMessage } from '../../../../jsOMS/Model/Message/Reload.js';

/** global: jsOMS */
export const RESPONSE_EVENTS = {
    'notify': notifyMessage, /** global: notifyMessage */
    'validation': formValidationMessage, /** global: formValidationMessage */
    'redirect': redirectMessage, /** global: redirectMessage */
    'reload': reloadMessage /** global: reloadMessage */
};