/**
 * Tab manager class.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    
    jsOMS.Autoloader.defineNamespace('jsOMS.UI.Component');
    
    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Tab = function (responseManager)
    {
        this.responseManager = responseManager;
    };

    /**
     * Bind & rebind UI elements.
     *
     * @param {string} [id] Element id
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.UI.Component.Tab.prototype.bind = function (id)
    {
        if (typeof id !== 'undefined') {
            const e = document.getElementById(id);

            if(e) {
                this.bindElement();
            }
        } else {
            var tabs = document.querySelectorAll('.tabview'),
                length = !tabs ? 0 : tabs.length;

            for (var i = 0; i < length; i++) {
                this.bindElement(tabs[i]);
            }
        }
    };

    /**
     * Bind & rebind UI element.
     *
     * @param {Object} [e] Element id
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.UI.Component.Tab.prototype.bindElement = function (e)
    {
        const nodes = e.querySelectorAll('.tab-links a');

        nodes.addEventListener('click', function (evt)
        {
            /* Change Tab */
            const attr = this.getAttribute('href').substring(1),
                cont = this.parentNode.parentNode.parentNode.children[1];

            jsOMS.removeClass(jsOMS.getByClass(this.parentNode.parentNode, 'active'), 'active');
            jsOMS.addClass(this.parentNode, 'active');
            jsOMS.removeClass(jsOMS.getByClass(cont, 'active'), 'active');
            jsOMS.addClass(jsOMS.getByClass(cont, attr), 'active');

            /* Modify url */

            jsOMS.preventAll(evt);
        });
    };
}(window.jsOMS = window.jsOMS || {}));
