/**
 * Module factory.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    
    jsOMS.Autoloader.defineNamespace('jsOMS.Module');
    
    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.Module.ModuleFactory = function ()
    {
    };

    /**
     * Get module instance.
     *
     * @param {string} module Module name
     * @param {Object} app Application reference
     *
     * @return {Object}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Module.ModuleFactory.getInstance = function (module, app)
    {
        return new jsOMS.Modules[module](app);
    };
}(window.jsOMS = window.jsOMS || {}));
