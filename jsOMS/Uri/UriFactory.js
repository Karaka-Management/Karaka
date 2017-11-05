/**
 * Uri factory.
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
    jsOMS.Autoloader.defineNamespace('jsOMS.Uri.UriFactory');

    /**
     * Uri values
     *
     * @var {Object}
     * @since 1.0.0
     */
    jsOMS.Uri.UriFactory.uri = {};

    /**
     * Set uri query
     *
     * @param {string} key Query key
     * @param {string} value Query value
     * @param {boolean} [overwrite] Overwrite if already exists?
     *
     * @return {boolean}
     *
     * @function
     *
     * @since 1.0.0
     */
    jsOMS.Uri.UriFactory.setQuery = function (key, value, overwrite)
    {
        overwrite = typeof overwrite !== 'undefined' ? overwrite : true;

        if (overwrite || !jsOMS.Uri.UriFactory.uri.hasOwnProperty(key)) {
            jsOMS.Uri.UriFactory.uri[key] = value;

            return true;
        }

        return false;
    };

    /**
     * Get query
     *
     * @param {string} key
     * 
     * @return {string}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.UriFactory.getQuery = function (key)
    {
        if (!jsOMS.Uri.UriFactory.uri.hasOwnProperty(key)) {
            return '';
        }

        return jsOMS.Uri.UriFactory.uri[key];
    };

    /**
     * Clear all uri components
     *
     * @return {boolean}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.UriFactory.clearAll = function() 
    {
        jsOMS.Uri.UriFactory.uri = {};

        return true;
    };

    /**
     * Clear uri component
     *
     * @param {string} key Uri key for component
     * 
     * @return {boolean}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.UriFactory.clear = function(key)
    {
        if(jsOMS.Uri.UriFactory.uri.hasOwnProperty(key)) {
            delete jsOMS.Uri.UriFactory.uri[key];

            return true;
        }

        return false;
    };

    /**
     * Clear uri components that follow a certain pattern
     *
     * @param {string} pattern Uri key pattern to remove
     * 
     * @return {boolean}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.UriFactory.clearLike = function(pattern) 
    {
        let success = false;
        const regexp = new RegExp(pattern);

        for(let key in jsOMS.Uri.UriFactory.uri) {
            if(jsOMS.Uri.UriFactory.uri.hasOwnProperty(key) && regexp.test(key)) {
                delete jsOMS.Uri.UriFactory.uri[key];
                success = true;
            }
        }

        return success;
    };

    /**
     * Remove multiple definitions of the same parameter
     *
     * The parameters will be recognized from right to left since it's easier to push at the end.
     *
     * @param {string} url Url
     *
     * @return {string}
     *
     * @function
     *
     * @since 1.0.0
     */
    jsOMS.Uri.UriFactory.unique = function (url)
    {
        const parts = url.split('?');

        if (parts.length >= 2) {
            let full = parts[1],
                pars  = full.split('&'),
                comps = {},
                spl   = null,
                length = pars.length;

            for (let i = 0; i < length; i++) {
                spl           = pars[i].split('=');
                comps[spl[0]] = spl[1];
            }

            pars = [];
            for (let a in comps) {
                if (comps.hasOwnProperty(a)) {
                    pars.push(a + '=' + comps[a]);
                }
            }

            url = parts[0] + '?' + pars.join('&');
        }

        return url;
    };

    /**
     * Build uri
     *
     * # = DOM id
     * . = DOM class
     * / = Current path
     * ? = Current query
     * @ =
     * $ = Other data
     * % = Current url
     *
     * @param {string} uri Raw uri
     * @param {Object} [toMatch] Key/value pair to replace in raw
     *
     * @function
     *
     * @since 1.0.0
     */
    jsOMS.Uri.UriFactory.build = function (uri, toMatch)
    {
        const current = jsOMS.Uri.Http.parseUrl(window.location.href);
        let parsed  = uri.replace(new RegExp('\{[\/#\?%@\.\$][a-zA-Z0-9\-]*\}', 'g'), function (match)
            {
                match = match.substr(1, match.length - 2);

                if (typeof toMatch !== 'undefined' && toMatch.hasOwnProperty(match)) {
                    return toMatch[match];
                } else if (typeof jsOMS.Uri.UriFactory.uri[match] !== 'undefined') {
                    return jsOMS.Uri.UriFactory.uri[match];
                } else if (match.indexOf('#') === 0) {
                    const e = document.getElementById(match.substr(1));

                    if(e) {
                        return e.value;
                    }

                    return '';
                } else if (match.indexOf('?') === 0) {
                    return jsOMS.Uri.Http.getUriQueryParameter(current.query, match.substr(1));
                } else if (match.indexOf('/') === 0) {
                    // todo: second match should return second path
                    return 'ERROR PATH';
                } else if (match === '%') {
                    return window.location.href;
                } else {
                    return match;
                }
            });

        if (parsed.indexOf('?') === -1) {
            parsed = parsed.replace('&', '?');
        }

        parsed = jsOMS.Uri.UriFactory.unique(parsed);

        return parsed;
    };

    /**
     * Set uri builder components.
     *
     * @return {void}
     *
     * @method
     *
     * @since  1.0.0
     */
    jsOMS.Uri.UriFactory.setupUriBuilder = function (uri)
    {
        jsOMS.Uri.UriFactory.setQuery('/scheme', uri.getScheme());
        jsOMS.Uri.UriFactory.setQuery('/host', uri.getHost());
        jsOMS.Uri.UriFactory.setQuery('/base', jsOMS.rtrim(uri.getBase(), '/'));
        jsOMS.Uri.UriFactory.setQuery('?', uri.getQuery());
        jsOMS.Uri.UriFactory.setQuery('%', uri.getUri());
        jsOMS.Uri.UriFactory.setQuery('#', uri.getFragment());
        jsOMS.Uri.UriFactory.setQuery('/', uri.getPath());
        jsOMS.Uri.UriFactory.setQuery(':user', uri.getUser());
        jsOMS.Uri.UriFactory.setQuery(':pass', uri.getPass());

        const query = uri.getQuery();

        for (let key in query) {
            if (query.hasOwnProperty(key)) {
                jsOMS.Uri.UriFactory.setQuery('?' + key, query[key]);
            }
        }
    };
}(window.jsOMS = window.jsOMS || {}));
