/**
 * Request manager class.
 *
 * Used for pooling requests.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    jsOMS.Autoloader.defineNamespace('jsOMS.Event');

    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.Event.EventManager = function ()
    {
        this.logger    = jsOMS.Log.Logger.getInstance();
        this.groups    = {};
        this.callbacks = {};
    };

    /**
     * Add event group (element)
     *
     * Adding the same event overwrites the existing one as "waiting"
     *
     * @param {string|int} group Group id
     * @param {string|int} id Event id
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Event.EventManager.prototype.addGroup = function (group, id)
    {
        if (typeof this.groups[group] === 'undefined') {
            this.groups[group] = {};
        }

        this.groups[group][id] = false;
    };

    /**
     * Resets the group status
     *
     * @param {string|int} group Group id
     *
     * @return {void}
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Event.EventManager.prototype.reset = function (group)
    {
        for (let id in this.groups[group]) {
            if (this.groups[group].hasOwnProperty(id)) {
                this.groups[group][id] = false;
            } 
        }
    };

    /**
     * Does group have outstanding events
     *
     * @param {string|int} group Group id
     *
     * @return {boolean}
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Event.EventManager.prototype.hasOutstanding = function (group)
    {
        if (typeof this.groups[group] === 'undefined') {
            return false;
        }

        for (let id  in this.groups[group]) {
            if (!this.groups[group].hasOwnProperty(id) || !this.groups[group][id]) {
                return true;
            }
        }

        return false;
    };

    /**
     * Trigger event finished
     *
     * Executes the callback specified for this group if all events are finished
     *
     * @param {string|int} group Group id
     * @param {string|int} id Event id
     * @param {Object} [data] Data for event
     *
     * @return {boolean}
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Event.EventManager.prototype.trigger = function (group, id, data)
    {
        id = typeof id !== 'undefined' ? id : 0;

        if(!this.callbacks.hasOwnProperty(group)) {
            return false;
        }

        if (typeof this.groups[group] !== 'undefined') {
            this.groups[group][id] = true;
        }

        if (!this.hasOutstanding(group)) {
            this.callbacks[group].func(data);

            if (this.callbacks[group].remove) {
                this.detach(group);
            } else if(this.callbacks[group].reset) {
                this.reset(group);
            }
        }
    };

    /**
     * Detach event
     *
     * @param {string|int} group Group id
     *
     * @return {void}
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Event.EventManager.prototype.detach = function (group)
    {
        delete this.callbacks[group];
        delete this.groups[group];
    };

    /**
     * Attach callback to event group
     *
     * @param {string|int} group Group id
     * @param {function} callback Callback
     * @param {boolean} remove Should be removed after execution
     * @param {boolean} reset Reset after triggering
     *
     * @return {boolean}
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Event.EventManager.prototype.attach = function (group, callback, remove, reset)
    {
        if(this.callbacks.hasOwnProperty(group)) {
            return false;
        }

        remove = typeof remove === 'undefined' ? false : remove;
        reset = typeof reset === 'undefined' ? false : reset;

        this.callbacks[group] = {remove: remove, reset: reset, func: callback};

        return true;
    };

    /**
     * Count events
     *
     * @return {int}
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Event.EventManager.prototype.count = function ()
    {
        return this.callbacks.length;
    };
}(window.jsOMS = window.jsOMS || {}));
