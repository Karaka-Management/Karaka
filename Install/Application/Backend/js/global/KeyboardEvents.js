/** global: jsOMS */
export const KEYBOARD_EVENTS = [
    {
        'element': '', // jump into search bar
        'keys': [17, 80],
        'callback': function (e) {document.getElementById('iSearchBox').focus();}
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
        'keys': [17, 39],
        'callback': function (e) {
            const focusable = document.querySelectorAll('button, input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                length = focusable.length;

            for (let i = 0; i < length; ++i) {
                if (document.activeElement === focusable[i]) {
                    if (i < length - 1) {
                        focusable[i + 1].focus();
                    } else {
                        focusable[0].focus();
                    }

                    return;
                }
            }

            focusable[0].focus();
        }
    }, {
        'element': '', // previous tab index
        'keys': [17, 37],
        'callback': function (e) {
            const focusable = document.querySelectorAll('button, input, select, textarea, [tabindex]:not([tabindex="-1"])'),
                length = focusable.length;

            for (let i = 0; i < length; ++i) {
                if (document.activeElement === focusable[i]) {
                    if (i > 0) {
                        focusable[i - 1].focus();
                    } else {
                        focusable[length - 1].focus();
                    }

                    return;
                }
            }

            focusable[0].focus();
        }
    }
];