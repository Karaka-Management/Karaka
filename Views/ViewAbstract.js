(function (jsOMS) {
    "use strict";
    
    jsOMS.ViewAbstract = function ()
    {
        this.element = null;
        this.data = [];
    };

    jsOMS.ViewAbstract.prototype.bind = function (node)
    {
        this.element = node;
    };

    jsOMS.ViewAbstract.prototype.addData = function(id, data, overwrite)
    {
        overwrite = typeof overwrite !== 'undefined' ?  overwrite : false;

        if(typeof this.data[id] === 'undefined' || overwrite) {
            this.data[id] = data;

            return true;
        }

        return false;
    };

    jsOMS.ViewAbstract.prototype.getData = function(id)
    {
        return typeof this.data[id] !== 'undefined' ? this.data[id] : undefined;
    };
}(window.jsOMS = window.jsOMS || {}));
