/**
 * LocalStorage class.
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
    jsOMS.DataStorage.LocalStorage = function ()
    {
    };

    /**
     * Is local storage available?
     *
     * @return {boolean}
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.DataStorage.LocalStorage.prototype.available = function ()
    {
        try {
            return 'localStorage' in window && window.localStorage !== null;
        } catch (e) {
            return false;
        }
    };
}(window.jsOMS = window.jsOMS || {}));
