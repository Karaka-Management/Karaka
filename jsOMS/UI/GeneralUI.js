/**
 * UI manager for handling basic ui elements.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.UI */
    jsOMS.Autoloader.defineNamespace('jsOMS.UI');

    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.UI.GeneralUI = function ()
    {

        this.visObs = null;
    };
    
    /**
     * Bind button.
     *
     * @param {string} [id] Button id (optional)
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.UI.GeneralUI.prototype.bind = function (id)
    {
        let e = null;
        if (typeof id !== 'undefined') {
            e = document.getElementById(id);
        } 
        
        this.bindHref(e);
        this.bindLazyLoad(e);
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
    jsOMS.UI.GeneralUI.prototype.bindHref = function (e)
    {
        e = e !== null ? e.querySelectorAll('[data-href]') : document.querySelectorAll('[data-href]');
        const length = e.length;

        for(let i = 0; i < length; i++) {
            e[i].addEventListener('click', function(event) {
                jsOMS.preventAll(event);
                window.location = jsOMS.Uri.UriFactory.build(this.getAttribute('data-href'));
            });
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
    jsOMS.UI.GeneralUI.prototype.bindLazyLoad = function (e)
    {
        e = e !== null ? e.querySelectorAll('[data-lazyload]') : document.querySelectorAll('[data-lazyload]');
        const length = e.length;

        /** global: IntersectionObserver */
        if(!this.visObs && window.IntersectionObserver) {
            this.visObs = new IntersectionObserver(function(eles, obs) {
                eles.forEach(ele => {
                    if (ele.intersectionRatio > 0) {
                        obs.unobserve(ele.target);
                        ele.target.src = ele.target.dataset.lazyload;
                        delete ele.target.dataset.lazyload;
                    }
                });
            });
        }

        for(let i = 0; i < length; i++) {
            if(!this.visObs) {
                e[i].src = e[i].dataset.lazyload;
                delete e[i].dataset.lazyload;
            } else {
                this.visObs.observe(e[i]);
            }
        }
    };
}(window.jsOMS = window.jsOMS || {}));
