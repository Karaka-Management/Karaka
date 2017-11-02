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

    /** @namespace jsOMS.Module */
    jsOMS.Autoloader.defineNamespace('jsOMS.Module');

    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.Module.ModuleManager = function (app)
    {
        this.modules = {};
        this.app = app;
    };

    /**
     * Get module.
     *
     * @param {string} module Module name
     *
     * @return {Object}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Module.ModuleManager.prototype.get = function (module)
    {
        if (typeof this.modules[module] === 'undefined') {
            this.modules[module] = jsOMS.Module.ModuleFactory.getInstance(module, this.app);
        }

        return this.modules[module];
    };
}(window.jsOMS = window.jsOMS || {}));
