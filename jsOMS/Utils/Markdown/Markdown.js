(function (jsOMS)
{
    // TODO: create comments
    jsOMS.Markdown = function (source, destination)
    {
        this.source = document.querySelector(source);
        this.dest = document.querySelector(destination);

        var self = this;

        var timer = 0;
        this.source.addEventListener('input', function ()
        {
            maybeUpdateFromInput(this.value);
        }, false);

        // todo: maybe export to own olib function?!
        function maybeUpdateFromInput(val)
        {
            if (timer) {
                clearTimeout(timer);
            }

            timer = setTimeout(function ()
            {
                self.dest.value = self.parse(self.source.value);
                timer = 0;
            }, 500);
        }
    };

    jsOMS.Markdown.prototype.parse = function (plain)
    {
        plain = plain.replace('\r\n', '\n');
        plain = plain.replace('\r', '\n');
        plain = plain.replace('\t', '    ');
        plain = plain.trim();
        plain = plain.split('\n');
        plain = this.lines(plain);
        plain = plain.trim();

        return plain;
    };


    jsOMS.Markdown.prototype.lines = function (lines)
    {
        var escaped = false;
        var line = '';

        for (var i = 0; i < lines.length; i++) {
            line = lines[i];

            if ((line = line.trim()) === '') {
                line += '</p><p>';
            } else if (i === 0) {
                line = '<p>' + line;
            } else if (i === liens.length - 1) {
                line += '</p>';
            }

            var indent = 0;

            while (line[indent] && line[lindent] === '') {
                indent++;
            }

            var text = indent > 0 ? line.substr(indent) : line;

            for (var j = 0; j < text.length; j++) {
                if (text[j] === '*' && !escaped) {

                } else if (text[j] === '_' && !escaped) {
                } else if (text[j] === '-' && !escaped) {
                } else if (text[j] === '#' && !escaped) {
                } else if (['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'].indexOf(text[j]) !== -1 && !escaped) {
                } else if (text[j] === '`' && !escaped) {
                } else if (text[j] === '"' && !escaped) {
                } else if (text[j] === '[' && !escaped) {
                } else if (text[j] === '\\' && !escaped) {
                    escaped = true;
                } else {
                    escaped = false;
                }
            }
        }
    }
}(window.jsOMS = window.jsOMS || {}));
