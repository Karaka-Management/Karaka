/**
 * Logger class.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    /** @namespace jsOMS.Log */
    jsOMS.Autoloader.defineNamespace('jsOMS.Log');

    /**
     * @constructor
     * 
     * @param {boolean} verbose Verbose logging
     * @param {boolean} ui Ui logging
     * @param {boolean} remote Remote logging
     *
     * @since 1.0.0
     */
    jsOMS.Log.Logger = function (verbose, ui, remote)
    {
        this.verbose = typeof verbose !== 'undefined' ? verbose : true;
        this.ui      = typeof ui !== 'undefined' ? ui : true;
        this.remote  = typeof remote !== 'undefined' ? remote : false;
    };

    jsOMS.Log.Logger.instance = null;

    /**
     * Get logging instance
     *
     * @param {boolean} [verbose] Verbose logging
     * @param {boolean} [ui] Ui logging
     * @param {boolean} [remote] Remote logging
     * 
     * @return {Object}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.getInstance = function(verbose, ui, remote) 
    {
        if(!jsOMS.Log.Logger.instance) {
            jsOMS.Log.Logger.instance = new jsOMS.Log.Logger(verbose, ui, remote);
        }

        return jsOMS.Log.Logger.instance;
    };

    jsOMS.Log.Logger.MSG_FULL = '{datetime}; {level}; {version}; {os}; {browser}; {path}; {message}';

    /**
     * Interpolate message
     *
     * @param {string} message Message structure
     * @param {Object} [context] Context to put into message
     * @param {string} [level] Log level
     * 
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.interpolate = function (message, context, level)
    {
        let newMessage = jsOMS.Log.Logger.MSG_FULL;

        for (let replace in context) {
            if (context.hasOwnProperty(replace)) {
                newMessage = newMessage.replace('{' + replace + '}', context[replace]);
            }
        }

        return newMessage;
    };

    /**
     * Create context
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * @param {string} level Log level
     * 
     * @return {Object}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.createContext = function (message, context, level)
    {
        context.datetime = (new Date()).toISOString();
        context.version  = '1.0.0';
        context.os       = jsOMS.Message.Request.Request.getOS();
        context.browser  = jsOMS.Message.Request.Request.getBrowser();
        context.path     = window.location.href;
        context.level    = level;
        context.message  = message;

        return context;
    };

    /**
     * Create log message
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * @param {string} level Log level
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.write = function (message, context, level)
    {
        context = this.createContext(message, context, level);

        if (this.verbose) {
            let color = '000';

            switch (level) {
                case 'info':
                case 'notice':
                case 'log':
                    color = '000';
                    break;
                case 'debug':
                    color = '289E39';
                    break;
                case 'warning':
                case 'alert':
                    color = 'FFA600';
                    break;
                case 'error':
                case 'critical':
                case 'emergency':
                    color = 'CF304A';
                    break;
                default:
            }

            console.log('%c' + this.interpolate(message, context, level), 'color: #' + color);
        }

        if (this.ui) {
            // todo: fill log box, set class and initiate animation
        }

        if (this.remote) {
            let request = new jsOMS.Message.Request.Request();
            request.setData(context);
            request.setType(jsOMS.Message.Response.Response.ResponseType.JSON);
            request.setUri('/{/lang}/api/log');
            request.setMethod(jsOMS.Message.Request.Request.RequestMethod.POST);
            request.setRequestHeader('Content-Type', 'application/json');
            request.setSuccess(function (xhr)
            {
            });
            request.send();
        }
    };

    /**
     * Create log message
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.emergency = function (message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, jsOMS.Log.LogLevel.EMERGENCY);
    };

    /**
     * Create log message
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.alert = function (message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, jsOMS.Log.LogLevel.ALERT);
    };

    /**
     * Create log message
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.critical = function (message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, jsOMS.Log.LogLevel.CRITICAL);
    };

    /**
     * Create log message
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.error = function (message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, jsOMS.Log.LogLevel.ERROR);
    };

    /**
     * Create log message
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.warning = function (message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, jsOMS.Log.LogLevel.WARNING);
    };

    /**
     * Create log message
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.notice = function (message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, jsOMS.Log.LogLevel.NOTICE);
    };

    /**
     * Create log message
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.info = function (message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, jsOMS.Log.LogLevel.INFO);
    };

    /**
     * Create log message
     *
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.debug = function (message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, jsOMS.Log.LogLevel.DEBUG);
    };

    /**
     * Create log message
     *
     * @param {string} level Log level
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.log = function (level, message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, context);
    };

    /**
     * Create log message
     *
     * @param {string} level Log level
     * @param {string} message Message to display
     * @param {Object} [context] Context to put into message
     * 
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Log.Logger.prototype.console = function (level, message, context)
    {
        context = typeof context === 'undefined' ? {} : context;

        this.write(message, context, jsOMS.Log.LogLevel.INFO);
    };
}(window.jsOMS = window.jsOMS || {}));
