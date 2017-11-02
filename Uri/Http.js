/**
 * Http Uri.
 *
 * This class is for creating, modifying and analysing http uris.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.Uri.UriFactory */
    jsOMS.Autoloader.defineNamespace('jsOMS.Uri.Http');

    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.Uri.Http = function (uri)
    {
        this.uri         = '';
        this.scheme      = '';
        this.host        = '';
        this.port        = '';
        this.user        = '';
        this.pass        = '';
        this.query       = null;
        this.queryString = '';
        this.fragment    = '';
        this.base        = '';
        this.root        = '/';

        this.set(uri);
    };

    /**
     * Parse uri
     *
     * @param {string} str Url to parse
     * @param {string} mode Parsing mode
     *
     * @return {Object}
     *
     * @throws {Error}
     *
     * @function
     *
     * @since 1.0.0
     */
    jsOMS.Uri.Http.parseUrl = function (str, mode)
    {
        mode = typeof mode === 'undefined' ? 'php' : mode;

        const key = ['source', 'scheme', 'authority', 'userInfo', 'user', 'pass', 'host', 'port',
                'relative', 'path', 'directory', 'file', 'query', 'fragment'
            ],
            parser     = {
                php: /^(?:([^:\/?#]+):)?(?:\/\/()(?:(?:()(?:([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?()(?:(()(?:(?:[^?#\/]*\/)*)()(?:[^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
                strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
                loose: /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/\/?)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/ // Added one optional slash to post-scheme to catch file:/// (should restrict this)
            };

        if (!parser.hasOwnProperty(mode)) {
            throw new Error('Unexpected parsing mode.', 'UriFactory', 52);
        }

        const m   = parser[mode].exec(str),
            uri = {};
        let i   = 14;

        while (i--) {
            if (m[i]) {
                uri[key[i]] = m[i];
            }
        }

        delete uri.source;

        return uri;
    };

    /**
     * Get Uri query parameters.
     *
     * @param {string} query Uri query
     * @param {string} name Name of the query to return
     *
     * @return {null|string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.getUriQueryParameter = function (query, name)
    {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");

        const regex   = new RegExp("[\\?&]*" + name + "=([^&#]*)"),
            results = regex.exec(query);

        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    };

    /**
     * Get all uri query parameters.
     *
     * @param {string} query Uri query
     *
     * @return {Object}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.getAllUriQueryParameters = function (query)
    {
        const params      = {};
        let keyValPairs = [],
            pairNum     = null;

        if (query.length) {
            keyValPairs = query.split('&');

            for (pairNum in keyValPairs) {
                const key = keyValPairs[pairNum].split('=')[0];

                if (!key.length) {
                    continue;
                }

                if (typeof params[key] === 'undefined') {
                    params[key] = [];
                }

                params[key].push(keyValPairs[pairNum].split('=')[1]);
            }
        }

        return params;
    };

    /**
     * Set uri.
     *
     * @param {string} uri Uri string
     *
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.set = function (uri)
    {
        this.uri = uri;

        const parsed = jsOMS.Uri.Http.parseUrl(this.uri, 'php');

        this.scheme = parsed['scheme'];
        this.host   = parsed['host'];
        this.port   = parsed['port'];
        this.user   = parsed['user'];
        this.pass   = parsed['pass'];
        this.path   = parsed['path'];

        if (this.path.endsWith('.php')) {
            this.path = this.path.substr(0, -4);
        }

        this.queryString = typeof parsed['query'] !== 'undefined' ? parsed['query'] : [];

        if (this.queryString !== null) {
            this.query = jsOMS.Uri.Http.getAllUriQueryParameters(this.queryString);
        }

        this.fragment = typeof parsed['fragment'] !== 'undefined' ? parsed['fragment'] : '';
        this.base     = this.scheme + '://' + this.host + this.root;
    };
    
    /**
     * Set root path.
     *
     * @param {string} rootPath Uri root path
     *
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.setRootPath = function(rootPath)
    {
        this.root = rootPath;
        this.set(this.uri);
    };

    /**
     * Get Uri base
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getBase = function()
    {
        return this.base;
    };

    /**
     * Get Uri scheme
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getScheme = function()
    {
        return this.scheme;
    };

    /**
     * Get Uri host
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getHost = function()
    {
        return this.host;
    };

    /**
     * Get Uri port
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getPort = function()
    {
        return this.port;
    };

    /**
     * Get Uri user
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getUser = function()
    {
        return this.user;
    };

    /**
     * Get Uri pass
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getPass = function()
    {
        return this.pass;
    };

    /**
     * Get Uri query
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getQuery = function()
    {
        return this.queryString;
    };

    /**
     * Get Uri
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getUri = function()
    {
        return this.uri;
    };

    /**
     * Get Uri fragment
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getFragment = function()
    {
        return this.fragment;
    };

    /**
     * Get Uri path
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getPath = function()
    {
        return this.path;
    };
    
    /**
     * Get Uri path offset
     *
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.Http.prototype.getPathOffset = function()
    {
        return jsOMS.substr_count(this.root, '/') - 1;
    };
}(window.jsOMS = window.jsOMS || {}));
