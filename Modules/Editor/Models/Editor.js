(function (jsOMS)
{
    "use strict";

    jsOMS.Autoloader.defineNamespace('jsOMS.Modules.Models.Editor');

    jsOMS.Modules.Models.Editor.Editor = function (id)
    {
        this.editor = document.getElementById(id);
    };

    jsOMS.Modules.Models.Editor.Editor.prototype.bind = function()
    {
        const editorButtons = this.editor.getElementsByClassName('editor-button'),
            editorTitle = this.editor.getElementsByClassName('editor-title')[0],
            editorContent = this.editor.getElementsByClassName('editor-content')[0],
            editorPreview = this.editor.getElementsByClassName('editor-preview')[0],
            length = editorButtons.length,
            self = this;

        for(let i = 0; i < length; i++) {
            editorButtons[i].addEventListener('click', function(event) {
                // todo: identify button by class and then call function for this class.
            });
        }
    };

    jsOMS.Modules.Models.Editor.Editor.prototype.getSelectedText = function()
    {
        let text            = '';
        const activeEl        = document.activeElement;
        const activeElTagName = activeEl ? activeEl.tagName.toLowerCase() : null;

        if (
            (activeElTagName === 'textarea' || activeElTagName === 'input') &&
            /^(?:text|search|password|tel|url)$/i.test(activeEl.type) &&
            (typeof activeEl.selectionStart === 'number')
        ) {
            text = activeEl.value.slice(activeEl.selectionStart, activeEl.selectionEnd);
        } else if (window.getSelection) {
            text = window.getSelection().toString();
        }

        return text;
    };
}(window.jsOMS = window.jsOMS || {}));