import { jsOMS } from '../../../../../jsOMS/Utils/oLib.js';
/** global: jsOMS */
/**
 * @todo Implement table/link navigation
 *      https://github.com/Karaka-Management/Karaka/issues/162
 */
export const KEYBOARD_EVENTS = [
    {
        'element': '', // jump into search bar
        'keys': [17, 80], // ctrl+p
        'callback': function (e) {document.getElementById('iSearchBox').focus();}
    }, {
        'element': 'form, input, textarea, select', // submit currently focused form with the first found submit element (add, update, save)
        'keys': [17, 13], // ctrl+enter
        'callback': function (e) {
            const focused = document.activeElement;
            let formId    = focused.closest('form');

            if (formId !== null) {
                formId = formId.id;
            }

            if (formId === null) {
                formId = focused.getAttribute('form');
            }

            if (formId === null) {
                formId = focused.getAttribute('data-form');
            }

            if (formId === null) {
                return;
            }

            const form    = window.omsApp.uiManager.getFormManager().get(formId);
            const buttons = form.getSubmit();
            const length  = buttons.length;

            let defaultSubmit = -1;

            for (let i = 0; i < length; ++i) {
                if (jsOMS.hasClass(buttons[i], 'vh')) {
                    continue;
                }

                if (jsOMS.hasClass(buttons[i], 'add-form')
                    || jsOMS.hasClass(buttons[i], 'update-form')
                    || jsOMS.hasClass(buttons[i], 'save-form')
                ) {
                    buttons[i].click();
                    break;
                }

                defaultSubmit = i;
            }

            if (defaultSubmit !== -1) {
                buttons[defaultSubmit].click();
            }
        }
    }, {
        'element': 'label, tr', // click label
        'keys': [13], // enter
        'callback': function (e) {document.activeElement.click();}
    }, {
        'element': '', // previous page
        'keys': [17, 66], // ctrl+b
        'callback': function (e) {window.history.back();}
    }, {
        'element': '', // next tabindex
        'keys': [17, 40], // ctrl+down
        'callback': function (e) {
            const focusable = document.querySelectorAll('button, input, select, textarea, [tabindex]:not([tabindex="-1"])');
            const length    = focusable.length;

            for (let i = 0; i < length; ++i) {
                if (document.activeElement === focusable[i]) {
                    let j = 1;
                    do {
                        if (i + j < length) {
                            focusable[i + j].focus();
                        } else {
                            focusable[0 + j - 1].focus();
                        }

                        ++j;
                    } while (j < length && document.activeElement === focusable[i]);

                    return;
                }
            }

            document.dispatchEvent(new KeyboardEvent('keypress', {keyCode: 9}));
        }
    }, {
        'element': '', // previous tab index
        'keys': [17, 38], // ctrl+up
        'callback': function (e) {
            const focusable = document.querySelectorAll('button, input, select, textarea, [tabindex]:not([tabindex="-1"])');
            const length    = focusable.length;

            for (let i = 0; i < length; ++i) {
                if (document.activeElement === focusable[i]) {
                    let j = 1;
                    do {
                        if (i - j + 1 > 0) {
                            focusable[i - j].focus();
                        } else {
                            focusable[length - j].focus();
                        }

                        ++j;
                    } while (j < length && document.activeElement === focusable[i]);

                    return;
                }
            }

            document.dispatchEvent(new KeyboardEvent('keypress', {keyCode: 9}));
        }
    }];
