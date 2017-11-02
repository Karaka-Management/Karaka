/**
 * Mouse manager class.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.UI.Input.Mouse */
    jsOMS.Autoloader.defineNamespace('jsOMS.UI.Input.Mouse');

    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.UI.Input.Mouse.MouseManager = function ()
    {
        this.elements = {};
        this.click    = {time: 0};
    };

    /**
     * Add input listener.
     *
     * @param {string} element Container id
     * @param {int} type Action type
     * @param {int} button Button
     * @param {callback} callback Callback
     * @param {bool} exact ??? todo: can't remember why this was important oO!!!
     *
     * @since  1.0.0
     */
    jsOMS.UI.Input.Mouse.MouseManager.prototype.add = function (element, type, button, callback, exact)
    {
        if (typeof this.elements[element] === 'undefined') {
            this.elements[element] = [];
        }

        this.bind(element, type);
        this.elements[element].push({callback: callback, type: type, button: button, exact: exact});
    };

    /**
     * Add input listener.
     *
     * @param {string} element Element id
     * @param {int} type Action type
     *
     * @since  1.0.0
     */
    jsOMS.UI.Input.Mouse.MouseManager.prototype.bind = function (element, type)
    {
        const self = this,
            e    = document.getElementById(element);

        if (!e) {
            return;
        }

        if (type === jsOMS.UI.Input.Mouse.EventType.CONTEXT) {
            e.addEventListener('contextmenu', function (event)
            {
                self.run(element, event);
            }, false);
        } else if (type === jsOMS.UI.Input.Mouse.EventType.LONGPRESS) {
            e.addEventListener('mousedown', function (event)
            {
                self.click.time = new Date().getTime();
            }, false);

            e.addEventListener('mouseup', function (event)
            {
                const duration = new Date().getTime() - self.click.time;

                if (duration > 650) {
                    self.run(element, event);
                }

                self.click.time = 0;
            }, false);
        } else if (type === jsOMS.UI.Input.Mouse.EventType.CLICK) {
            e.addEventListener('click', function (event)
            {
                self.run(element, event);
            }, false);
        }
    };

    /**
     * Run mouse input callback.
     *
     * @param {string} element Element id
     * @param {Object} event Click event
     *
     * @since  1.0.0
     */
    jsOMS.UI.Input.Mouse.MouseManager.prototype.run = function (element, event)
    {
        if (typeof this.elements[element] === 'undefined') {
            throw 'Unexpected elmenet!';
        }

        const actions = this.elements[element],
            length  = actions.length;

        for (let i = 0; i < length; i++) {
            if ((!actions[i].exact || event.target.getAttribute('id') === element) && actions[i].button === event.button) {
                jsOMS.preventAll(event);
                actions[i].callback();
            }
        }
    };
}(window.jsOMS = window.jsOMS || {}));
