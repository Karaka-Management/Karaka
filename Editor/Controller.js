(function (jsOMS)
{
    "use strict";

    jsOMS.Autoloader.defineNamespace('jsOMS.Modules');

    jsOMS.Modules.Editor = function(app)
    {
        this.app = app;
        this.editors = {};
    };

    jsOMS.Modules.Editor.prototype.bind = function(id)
    {
        const e = typeof id === 'undefined' ? document.getElementsByClassName('m-editor') : [document.getElementById(id)],
            length = e.length;

        for(let i = 0; i < length; i++) {
            this.bindElement(e[i]);
        }
    };

    jsOMS.Modules.Editor.prototype.bindElement = function(editor)
    {
        if(typeof editor === 'undefined' || !editor) {
            // todo: do logging

            return;
        }

        this.editors[editor.id] = new jsOMS.Modules.Models.Editor.Editor(editor.id);
        this.editors[editor.id].bind();
    };
}(window.jsOMS = window.jsOMS || {}));

jsOMS.ready(function ()
{
    "use strict";

    window.omsApp.moduleManager.get('Editor').bind();
});
