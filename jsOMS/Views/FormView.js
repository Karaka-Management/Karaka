/**
 * Form view.
 *
 * The form view contains a single form and it's data elements. Form actions are no longer handled by
 * the browser but through this view. The view also provides additional functionality for non-default
 * form elements such as canvas etc.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    /** @namespace jsOMS.Views */
    jsOMS.Autoloader.defineNamespace('jsOMS.Views');

    /**
     * @constructor
     *
     * @param {string} id Form id
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView = function (id)
    {
        this.id = id;

        this.initializeMembers();
        this.bind();
        this.success = null;
    };

    /**
     * Initialize members
     *
     * Pulled out since this is used in a cleanup process
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.initializeMembers = function ()
    {
        this.submitInjects = [];
        this.method        = 'POST';
        this.action        = '';
    };

    /**
     * Get method
     *
     * @return {string}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.getMethod = function ()
    {
        return this.method;
    };

    /**
     * Get action
     *
     * @return {string}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.getAction = function ()
    {
        return this.action;
    };

    /**
     * Get submit elements
     *
     * @return {Object}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.getSubmit = function ()
    {
        return document.querySelectorAll('#' + this.id + ' input[type=submit], button[form=' + this.id + '][type=submit]');
    };

    /**
     * Get success callback
     *
     * @return {callback}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.getSuccess = function ()
    {
        return this.success;
    };

    /**
     * Set success callback
     *
     * @param {callback} callback Callback
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.setSuccess = function (callback)
    {
        this.success = callback;
    };

    /**
     * Inject submit with post callback
     *
     * @param {callback} callback Callback
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.injectSubmit = function (callback)
    {
        this.submitInjects.push(callback);
    };

    /**
     * Get form elements
     *
     * @return {Array}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.getFormElements = function ()
    {
        const form = document.getElementById(this.id);

        if(!form) {
            return [];
        }

        const selects   = form.getElementsByTagName('select'),
            textareas = form.getElementsByTagName('textarea'),
            inputs    = form.getElementsByTagName('input'),
            canvas    = form.getElementsByTagName('canvas'),
            external  = document.querySelectorAll('[form=' + this.id + ']');

        return Array.prototype.slice.call(inputs).concat(Array.prototype.slice.call(selects), Array.prototype.slice.call(textareas), Array.prototype.slice.call(external));
    };

    /**
     * Get form data
     *
     * @return {Object}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.getData = function ()
    {
        const data     = {},
            elements = this.getFormElements(),
            length   = elements.length;

        let value = null;

        for (let i = 0; i < length; i++) {
            if(elements[i].tagName.toLowerCase() === 'canvas') {
                value = elements[i].toDataURL('image/png');
            } else {
                value = elements[i].value;
            }

            data[jsOMS.Views.FormView.getElementId(elements[i])] = value;
        }

        return data;
    };

    /**
     * Get form id
     *
     * @return {string}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.getId = function ()
    {
        return this.id;
    };

    /**
     * Validate form
     *
     * @return {boolean}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.isValid = function ()
    {
        const elements = this.getFormElements(),
            length   = elements.length;

        try {
            for (let i = 0; i < length; i++) {
                if ((elements[i].required && elements[i].value === '') || (typeof elements[i].pattern !== 'undefined' && elements[i].pattern !== '' && !(new RegExp(elements[i].pattern)).test(elements[i].value))) {
                    return false;
                }
            }
        } catch (e) {
            jsOMS.Log.Logger.instance.error(e);
        }

        return true;
    };

    /**
     * Get form element
     *
     * @return {Object}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.getElement = function ()
    {
        return document.getElementById(this.getId());
    };

    /**
     * Get form element id
     *
     * @return {string}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.getElementId = function (e)
    {
        let id = e.getAttribute('name');

        if (!id) {
            id = e.getAttribute('id');
        } else {
            return id;
        }

        if (!id) {
            id = e.getAttribute('type');
        } else {
            return id;
        }

        return id;
    };

    /**
     * Get submit injects
     *
     * @return {Object}
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.getSubmitInjects = function ()
    {
        return this.submitInjects;
    };

    /**
     * Bind form
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.bind = function ()
    {
        this.clean();

        const e = document.getElementById(this.id);

        if(!e) {
            return;
        }

        this.method = e.attributes['method'].value;
        this.action = e.action;

        const elements = this.getFormElements(),
            length   = elements.length;

        for (let i = 0; i < length; i++) {
            switch (elements[i].tagName) {
                case 'input':
                    jsOMS.UI.Input.bind(elements[i]);
                    break;
                case 'select':
                    this.bindSelect(elements[i]);
                    break;
                case 'textarea':
                    this.bindTextarea(elements[i]);
                    break;
                case 'button':
                    this.bindButton(elements[i]);
                    break;
                default:
            }
        }
    };

    /**
     * Unbind form
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.unbind = function ()
    {
        const elements = this.getFormElements(),
            length   = elements.length;

        for (let i = 0; i < length; i++) {
            switch (elements[i].tagName) {
                case 'input':
                    jsOMS.UI.Input.unbind(elements[i]);
                    break;
                case 'select':
                    this.bindSelect(elements[i]);
                    break;
                case 'textarea':
                    this.bindTextarea(elements[i]);
                    break;
                case 'button':
                    this.bindButton(elements[i]);
                    break;
                default:
            }
        }
    };

    /**
     * Clean form
     *
     * @since 1.0.0
     */
    jsOMS.Views.FormView.prototype.clean = function ()
    {
        this.unbind();
        this.initializeMembers();
    };
}(window.jsOMS = window.jsOMS || {}));
