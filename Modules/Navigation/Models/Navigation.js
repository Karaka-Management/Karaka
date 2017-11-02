/**
 * Navigation class.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.Modules.Navigation.Models */
    jsOMS.Autoloader.defineNamespace('jsOMS.Modules.Navigation.Models');

    /**
     * Construct
     *
     * @param {Object} data Initialization (optional)
     *
     * @since 1.0.0
     */
    jsOMS.Modules.Navigation.Models.Navigation = function (data)
    {
        if (typeof data === 'undefined') {
            this.scrollPosition = {x: 0, y: 0};
            this.activeLinks    = {};
            this.visible        = true;
            this.openCategories = {};
        } else {
            this.scrollPosition = typeof data.scrollPosition === 'undefined' ? {x: 0, y: 0} : data.scrollPosition;
            this.activeLinks    = typeof data.activeLinks === 'undefined' ? {} : data.activeLinks;
            this.visible        = typeof data.visible === 'undefined' ? true : data.visible;
            this.openCategories = typeof data.openCategories === 'undefined' ? {} : data.openCategories;
        }
    };

    /**
     * Set scroll position
     *
     * @param {int} x Horizontal position
     * @param {int} y Vertical position
     *
     * @return {void}
     *
     * @since 1.0.0
     */
    jsOMS.Modules.Navigation.Models.Navigation.prototype.setScrollPosition = function (x, y)
    {
        this.scrollPosition.x = x;
        this.scrollPosition.y = y;
    };

    /**
     * Get scroll position
     *
     * @return {Object}
     *
     * @since 1.0.0
     */
    jsOMS.Modules.Navigation.Models.Navigation.prototype.getScrollPosition = function ()
    {
        return this.scrollPosition;
    };

    /**
     * Open navigation category
     *
     * @param {string} id Category id
     *
     * @return {void}
     *
     * @since 1.0.0
     */
    jsOMS.Modules.Navigation.Models.Navigation.prototype.setOpen = function (id)
    {
        this.openCategories[id] = true;
    };

    /**
     * Close navigation category
     *
     * @param {string} id Category id
     *
     * @return {void}
     *
     * @since 1.0.0
     */
    jsOMS.Modules.Navigation.Models.Navigation.prototype.setClose = function (id)
    {
        delete this.openCategories[id];
    };

    /**
     * Get open navigation elements
     *
     * @return {Object}
     *
     * @since 1.0.0
     */
    jsOMS.Modules.Navigation.Models.Navigation.prototype.getOpen = function ()
    {
        return this.openCategories;
    };

    jsOMS.Modules.Navigation.Models.Navigation.prototype.active = function (id)
    {
        this.allInactive();
    };

    jsOMS.Modules.Navigation.Models.Navigation.prototype.allInactive = function ()
    {

    };

    jsOMS.Modules.Navigation.Models.Navigation.prototype.inactive = function (id)
    {
    };

    /**
     * Set navigation visibility
     *
     * @param {bool} visible Visibility
     *
     * @return {bool}
     *
     * @since 1.0.0
     */
    jsOMS.Modules.Navigation.Models.Navigation.prototype.setVisible = function (visible)
    {
        this.visible = visible;
    };

    /**
     * Is navigation visible
     *
     * @return {bool}
     *
     * @since 1.0.0
     */
    jsOMS.Modules.Navigation.Models.Navigation.prototype.isVisible = function ()
    {
        return this.visible;
    };
}(window.jsOMS = window.jsOMS || {}));
