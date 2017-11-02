/**
 * CookieJar class.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    
    jsOMS.Autoloader.defineNamespace('jsOMS.DataStorage');
    
    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.DataStorage.CookieJar = function ()
    {
    };

    /**
     * Saving data to cookie
     *
     * @param {string} cName Cookie name
     * @param {string} value Value to save
     * @param {number} exdays Lifetime for the cookie
     * @param {string} domain Domain for the cookie
     * @param {string} path Path for the cookie
     *
     * @return array
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.DataStorage.CookieJar.prototype.setCookie = function (cName, value, exdays, domain, path)
    {
        const exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        const cValue = encodeURI(value) + ((exdays === null) ? "" : "; expires=" + exdate.toUTCString()) + ";domain=" + domain + ";path=" + path;
        document.cookie = cName + "=" + cValue;
    };

    /**
     * Loading cookie data
     *
     * @param {string} cName Cookie name
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.DataStorage.CookieJar.prototype.getCookie = function (cName)
    {
        let cValue = document.cookie,
            cStart = cValue.indexOf(" " + cName + "=");

        if (cStart === -1) {
            cStart = cValue.indexOf(cName + "=");
        }

        if (cStart === -1) {
            cValue = null;
        } else {
            cStart = cValue.indexOf("=", cStart) + 1;
            let cEnd = cValue.indexOf(";", cStart);

            if (cEnd === -1) {
                cEnd = cValue.length;
            }

            cValue = decodeURI(cValue.substring(cStart, cEnd));
        }
        return cValue;
    };
}(window.jsOMS = window.jsOMS || {}));
