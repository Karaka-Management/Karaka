/** global: jsOMS */
export const KEYBOARD_EVENTS = [
    {
        'element': '', // jump into search bar
        'keys': [17, 80],
        'callback': function (e) {document.getElementById('iSearchBox').focus();}
    }, {
        'element': '', // submit currently focused form
        'keys': [17, 13],
        'callback': function (e) {
            const focused = document.activeElement;
            let formId    = focused.closest('form');

            if (formId === null) {
                formId = focused.getAttribute('form');
            }

            if (formId === null) {
                formId = focused.getAttribute('data-form');
            }

            if (formId === null) {
                return;
            }

            window.omsApp.uiManager.getFormManager().submit(
                window.omsApp.uiManager.getFormManager().get(formId)
            );
        }
    }, {
        'element': 'label, tr', // click label
        'keys': [13],
        'callback': function (e) {document.activeElement.click();}
    }, {
        'element': '', // previous page
        'keys': [17, 66],
        'callback': function (e) {window.history.back();}
    }, {
        'element': '', // next tabindex
        'keys': [17, 40],
        'callback': function (e) {
            const focusable = document.querySelectorAll('button, input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                length      = focusable.length;

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
        'keys': [17, 38],
        'callback': function (e) {
            const focusable = document.querySelectorAll('button, input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                length      = focusable.length;

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
    }
];