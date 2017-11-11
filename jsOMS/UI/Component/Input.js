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
    
    /** @namespace jsOMS.UI.Input*/
    jsOMS.Autoloader.defineNamespace('jsOMS.UI.Input');

    /**
     * Unbind input element
     *
     * @param {Object} input Input element
     *
     * @since 1.0.0
     */
    jsOMS.UI.Input.unbind = function (input)
    {
        this.app.inputManager.getKeyboardManager().unbind(input);
        /** global: changeBind */
        input.removeEventListener('change', changeBind, false);
    };

    /**
     * Bind input elment
     *
     * @param {Object} input Input elment
     *
     * @since 1.0.0
     */
    jsOMS.UI.Input.bindElement = function (input)
    {
        if(typeof input === 'undefined') {
            throw 'Input element required'
        }

        const self = this;

        input.addEventListener('change', function changeBind(event)
        {
            /* Handle remote datalist/autocomplete input element */
            let listId, list;
            if (typeof (listId = this.getAttribute('list')) !== 'undefined' && (list = document.getElementById(listId)).getAttribute('data-list-src') !== 'undefined') {
                self.addRemoteDatalistOptions(this, list);
            }

            /* Handle html defined functions */
            let change;
            if (typeof (change = this.getAttribute('data-change-func')) !== 'undefined') {
                change(this);
            }

            /* Handle pre-defined dynamic change events */
            let ref;
            if (typeof (ref = this.getAttribute('data-ref')) !== 'undefined') {
                let e = document.getElementById(ref);

                if(!e) {
                    return;
                }

                switch (e.tagName) {
                    case 'ul':
                        break;
                    case 'table':
                        break;
                    default:
                }
            }
        });

        let dataButton;
        if (typeof (dataButton = input.getAttribute('data-button')) !== 'undefined') {
            this.app.inputManager.getKeyboardManager().bind(input, 13, function ()
            {
                const db = document.getElementById(dataButton);

                if(db) { 
                    db.click();
                }
            });
        }
    };

    /**
     * Add remote datalist options
     *
     * This only applies for datalists that have remote options
     *
     * @param {Object} input Input elment
     * @param {Object} datalist Datalist elment
     *
     * @since 1.0.0
     */
    jsOMS.UI.Input.addRemoteDatalistOptions = function (input, datalist)
    {
        this.clearDatalistOptions(datalist);

        const request = new jsOMS.Message.Request();
        request.setData(input.value);
        request.setType(jsOMS.Message.Response.ResponseType.JSON);
        request.setUri(datalist.getAttribute('data-list-src'));
        request.setMethod(jsOMS.Message.Request.RequestMethod.POST);
        request.setRequestHeader('Content-Type', 'application/json');
        request.setSuccess(function (xhr)
        {
            try {
                const o              = JSON.parse(xhr.response),
                    response       = new jsOMS.Message.Response(o),
                    responseLength = response.count();
                let tempResponse   = null,
                    success        = null;

                for (let k = 0; k < responseLength; k++) {
                    tempResponse = response.getByIndex(k);

                    let option = null,
                        data   = tempResponse.getData(),
                        length = data.length;

                    for (let i = 0; i < length; i++) {
                        option       = document.createElement('option');
                        option.value = tempResponse.value;
                        option.text  = tempResponse.text;

                        datalist.appendChild(option);
                    }
                }
            } catch (exception) {
                jsOMS.Log.Logger.instance.error('Invalid JSON object: ' + xhr, 'FormManager');
            }
        });

        request.send();
    };

    /**
     * Remove all datalist options from datalist
     *
     * @param {Object} datalist Datalist elment
     *
     * @since 1.0.0
     */
    jsOMS.UI.Input.clearDatalistOptions = function (datalist)
    {
        const length = datalist.options.length;

        for (let i = 0; i < length; i++) {
            datalist.remove(0);
        }
    };
}(window.jsOMS = window.jsOMS || {}));
