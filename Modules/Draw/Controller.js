(function (jsOMS) {
    "use strict";
    /** @namespace jsOMS.Modules */
    jsOMS.Autoloader.defineNamespace('jsOMS.Modules');

    jsOMS.Modules.Draw = function (app) {
        this.app = app;
        this.editors = [];
    };

    jsOMS.Modules.Draw.prototype.bind = function (id) {
        let temp = null;

        if (typeof id !== 'undefined') {
            /** global: jsOMS */
            temp = new jsOMS.Modules.Draw.Editor(document.getElementById(id));
            temp.bind();

            this.editors.push(temp);
        } else {
            const canvas = document.getElementsByClassName('m-draw'),
                length = canvas.length;

            this.editors = [];

            /* Handle media forms */
            for (let c = 0; c < canvas.length; c++) {
                temp = new jsOMS.Modules.Draw.Editor(canvas[c], this.app);
                temp.bind();

                this.editors.push(temp);
            }
        }
    };

    jsOMS.Modules.Draw.prototype.getElements = function() {
        return this.editors;
    };

    jsOMS.Modules.Draw.prototype.count = function() {
        return this.editors.length;
    };
}(window.jsOMS = window.jsOMS || {}));

jsOMS.ready(function () {
    window.omsApp.moduleManager.get('Draw').bind();
});
