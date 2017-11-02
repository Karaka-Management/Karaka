(function (jsOMS) {
    "use strict";
    
    jsOMS.Autoloader.defineNamespace('jsOMS.Route');

    // TODO: create comments
    jsOMS.Route.Route = function () 
    {
        this.routes = null;
    };

    // TODO: create comments
    jsOMS.Route.prototype.add = function (path, callback, exact) 
    {
        exact = typeof exact !== 'undefined' ? exact : true;

        // todo: create array key path like i did for php
    };
}(window.jsOMS = window.jsOMS || {}));
