/**
 * Form manager class.
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
    jsOMS.Autoloader.defineNamespace('jsOMS.UI.Component');

    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form = function (app)
    {
        this.app    = app;
        this.forms  = {};
        this.ignore = {};
    };

    /**
     * Get form
     *
     * @param {string} id Form Id
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form.prototype.get = function (id)
    {
        return this.forms[id];
    };

    /**
     * Is form ignored?
     *
     * @param {string} id Form Id
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form.prototype.isIgnored = function (id)
    {
        return this.ignore.indexOf(id) !== -1;
    };

    /**
     * Unbind form
     *
     * @param {string} id Form Id
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form.prototype.unbind = function (id)
    {

    };

    /**
     * Bind form
     *
     * @param {string} id Form Id (optional)
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form.prototype.bind = function (id)
    {
        if (typeof id !== 'undefined' && typeof this.ignore[id] === 'undefined') {
            this.bindForm(id);
        } else {
            const forms  = document.getElementsByTagName('form'),
                length = !forms ? 0 : forms.length;

            for (var i = 0; i < length; i++) {
                if (typeof forms[i].getAttribute('id') !== 'undefined' && forms[i].getAttribute('id') !== null && typeof this.ignore[forms[i].getAttribute('id')] === 'undefined') {
                    this.bindForm(forms[i].getAttribute('id'));
                }
            }
        }
    };

    /**
     * Bind form
     *
     * @param {string} id Form Id
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form.prototype.bindForm = function (id)
    {
        if (typeof id === 'undefined' || !id) {
            jsOMS.Log.Logger.instance.info('A form doesn\'t have an ID.');
            return;
        }

        const self       = this;
        this.forms[id] = new jsOMS.Views.FormView(id);

        this.unbind(id);

        const submits = this.forms[id].getSubmit(),
            length = submits.length;

        for(let i = 0; i < length; i++) {
            submits[i].addEventListener('click', function (event)
            {
                jsOMS.preventAll(event);
                self.submit(self.forms[id]);
            });
        }
    };

    /**
     * Unbind form
     *
     * @param {string} id Form Id
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form.prototype.unbindForm = function (id)
    {
        // todo: do i need the findex? can't i just use id?
        let findex = 0;

        if ((findex = this.forms[id]) !== 'undefined') {
            this.forms[id].unbind();
            this.forms.splice(findex, 1);

            return true;
        }

        return false;
    };

    /**
     * Submit form
     *
     * Calls injections first befor executing the actual form submit
     *
     * @param {Object} form Form object
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form.prototype.submit = function (form)
    {
        /* Handle injects */
        const self    = this,
            injects = form.getSubmitInjects();
        let counter = 0;

        // todo: test if attach necessary (maybe already attached in event manager)
        // Register normal form behavior
        this.app.eventManager.attach(form.getId(), function ()
        {
            self.submitForm(form);
        });

        // Run all injects first
        for (let property in injects) {
            if (injects.hasOwnProperty(property)) {
                counter++;
                this.app.eventManager.addGroup(form.getId(), counter);
                const result = injects[property](form, counter, form.getId());

                if(result === false) {
                    return;
                }
            } else {
                jsOMS.Log.Logger.instance.warning('Invalid property.');
            }
        }

        if(counter === 0) {
            this.app.eventManager.trigger(form.getId());
        }
    };

    /**
     * Submit form data
     *
     * Submits the main form data
     *
     * @param {Object} form Form object
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form.prototype.submitForm = function (form)
    {
        if (!form.isValid()) {
            jsOMS.Log.Logger.instance.debug('Form "' + form.getId() + '" has invalid values.');
            return;
        }

        /* Handle default submit */
        const request = new jsOMS.Message.Request.Request(),
            self    = this;

        request.setData(form.getData());
        request.setType(jsOMS.Message.Response.ResponseType.JSON);
        request.setUri(form.getAction());
        request.setMethod(form.getMethod());
        request.setRequestHeader('Content-Type', 'application/json');
        request.setSuccess(function (xhr)
        {
            try {
                const o            = JSON.parse(xhr.response),
                    response       = new jsOMS.Message.Response.Response(o),
                    responseLength = response.count();
                let tempResponse   = null,
                    success        = null;

                /* Handle responses (can be multiple response object) */
                for (let k = 0; k < responseLength; k++) {
                    tempResponse = response.getByIndex(k);

                    if ((success = form.getSuccess()) !== null) {
                        success(tempResponse);
                    } else {
                        self.app.responseManager.run(tempResponse.type, tempResponse, request);
                    }
                }
            } catch (e) {
                jsOMS.Log.Logger.instance.error('Invalid form response. \n' +
                    'URL: ' + form.getAction() + '\n' +
                    'Request: ' + JSON.stringify(form.getData()) + '\n' +
                    'Response: ' + xhr.response
                );

                return false;
            }
        });

        request.send();
    };

    /**
     * Count the bound forms
     *
     * @return {number}
     *
     * @since 1.0.0
     */
    jsOMS.UI.Component.Form.prototype.count = function ()
    {
        return this.forms.length;
    };
}(window.jsOMS = window.jsOMS || {}));
