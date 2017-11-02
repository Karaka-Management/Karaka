/**
 * Account type.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    
    jsOMS.Autoloader.defineNamespace('jsOMS.Account');

    jsOMS.Account.AccountType = Object.freeze({
        USER: 0,
        GROUP: 1
    });
}(window.jsOMS = window.jsOMS || {}));
