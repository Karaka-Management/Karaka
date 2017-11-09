(function (jsOMS)
{
    "use strict";
    /** @namespace jsOMS.Modules.Draw */
    jsOMS.Autoloader.defineNamespace('jsOMS.Modules.Draw');

    jsOMS.Modules.Draw.Editor = function (editor, app)
    {
        this.editor = editor;
        this.app = app;
        this.canvas = document.getElementsByTagName('canvas')[0];
        this.canvasContainer = this.canvas.parentElement;
        this.ctx = this.canvas.getContext("2d");

        let canvasStyle = window.getComputedStyle(this.canvas, null),
            canvasContainerStyle = window.getComputedStyle(this.canvasContainer, null);

        this.resize({
            width: parseFloat(canvasContainerStyle.width) - parseFloat(canvasContainerStyle.paddingLeft) - parseFloat(canvasContainerStyle.paddingRight) - parseFloat(canvasContainerStyle.borderLeftWidth) - parseFloat(canvasStyle.borderLeftWidth),
            height: parseFloat(canvasContainerStyle.height) - parseFloat(canvasContainerStyle.paddingTop) - parseFloat(canvasContainerStyle.paddingBottom) - parseFloat(canvasContainerStyle.borderRightWidth) - parseFloat(canvasStyle.borderRightWidth)
        });

        // Backup for undo.
        this.canvasBackup = document.createElement('canvas');
        this.ctxBackup = this.canvasBackup.getContext("2d");

        this.size = 1;
        this.type = jsOMS.Modules.Draw.DrawTypeEnum.DRAW;
        this.color = '#000000';
        this.drawFlag = false;
        this.oldPos = {x: 0, y: 0};
        this.newPos = {x: 0, y: 0};

        // All backup steps need to be stored here (draw, resize etc.)
        // Undo means the whole canvas will be redrawn on the canvasBackup without the last step
        this.undoHistory = [];
        this.redoHistory = [];
    };

    jsOMS.Modules.Draw.Editor.prototype.bind = function ()
    {
        const self = this;

        this.initCanvas();

        console.log(this.canvasContainer);

        this.app.eventManager.attach(this.canvasContainer.id, function(evt) {
            self.canvasStyle = window.getComputedStyle(self.canvas, null);
            self.canvasContainerStyle = window.getComputedStyle(self.canvasContainer, null);

            this.resize({
                width: parseFloat(self.canvasContainerStyle.width) - parseFloat(self.canvasContainerStyle.paddingLeft) - parseFloat(self.canvasContainerStyle.paddingRight) - parseFloat(self.canvasContainerStyle.borderLeftWidth) - parseFloat(self.canvasStyle.borderLeftWidth),
                height: parseFloat(self.canvasContainerStyle.height) - parseFloat(self.canvasContainerStyle.paddingTop) - parseFloat(self.canvasContainerStyle.paddingBottom) - parseFloat(self.canvasContainerStyle.borderRightWidth) - parseFloat(self.canvasStyle.borderRightWidth)
            });
        });
        this.app.uiManager.getDOMObserver().observe(this.canvasContainer, {childList: true, subtree: true});

        // Handle draw and resize
        this.canvas.addEventListener('mousemove', function (evt)
        {
            if (!self.drawFlag || self.type === jsOMS.Modules.Draw.DrawTypeEnum.DRAW) {
                self.oldPos = self.newPos;
                self.newPos = self.mousePosition(evt);

                if (self.type === jsOMS.Modules.Draw.DrawTypeEnum.DRAW) {
                    self.draw(self.oldPos, self.newPos);
                }
            }
        }, false);

        this.canvas.addEventListener("mousedown", function (evt)
        {
            self.drawFlag = true;
            self.oldPos = self.newPos;
            self.newPos = self.mousePosition(evt);

            if (self.drawFlag && self.type === jsOMS.Modules.Draw.DrawTypeEnum.DRAW) {
                self.draw(self.newPos, self.newPos);
            } else if (self.drawFlag && self.type === jsOMS.Modules.Draw.DrawTypeEnum.RECTANGLE || self.type === jsOMS.Modules.Draw.DrawTypeEnum.LINE || self.type === jsOMS.Modules.Draw.DrawTypeEnum.CIRCLE) {
                self.oldPos = self.newPos;
                self.newPos = self.mousePosition(evt);
            }
        }, false);

        this.canvas.addEventListener("mouseup", function (evt)
        {
            self.oldPos = self.newPos;
            self.newPos = self.mousePosition(evt);

            if (self.drawFlag && self.type === jsOMS.Modules.Draw.DrawTypeEnum.RECTANGLE || self.type === jsOMS.Modules.Draw.DrawTypeEnum.LINE || self.type === jsOMS.Modules.Draw.DrawTypeEnum.CIRCLE) {
                self.draw(self.oldPos, self.newPos);
            }

            self.drawFlag = false;
        }, false);

        this.canvas.addEventListener("mouseout", function (evt)
        {
            self.oldPos = self.newPos;
            self.newPos = self.mousePosition(evt);

            self.draw(self.oldPos, self.newPos);
            self.drawFlag = false;
            document.body.style.cursor = 'default';
        }, false);
    };

    jsOMS.Modules.Draw.Editor.prototype.initCanvas = function()
    {
        const img = this.canvas.getAttribute('data-src'),
            self = this;

        if(img !== null && typeof img !== 'undefined' && img.length > 0) {
            /** global: Image */
            let imgObj = new Image();

            imgObj.addEventListener('load', function() {
                self.canvas.width = imgObj.width;
                self.canvas.height = imgObj.height;
                self.canvas.getContext("2d").drawImage(imgObj, 0, 0);
            });

            imgObj.src = img;
        }
    };

    jsOMS.Modules.Draw.Editor.prototype.draw = function (start, end)
    {
        if (this.drawFlag) {
            this.ctx.beginPath();
            this.ctx.strokeStyle = this.color;
            this.ctx.lineWidth = this.size;

            if (this.type === jsOMS.Modules.Draw.DrawTypeEnum.DRAW) {
                this.ctx.moveTo(start.x, start.y);
                this.ctx.lineTo(end.x, end.y);
            } else if (this.type === jsOMS.Modules.Draw.DrawTypeEnum.RECTANGLE) {
                this.ctx.rect(start.x, start.y, end.x - start.x, end.y - start.y);
            } else if (this.type === jsOMS.Modules.Draw.DrawTypeEnum.CIRCLE) {
                this.ctx.arc(start.x, start.y, Math.sqrt((end.x - start.x) * (end.x - start.x) + (end.y - start.y) * (end.y - start.y)), 0, 2 * Math.PI);
            } else if (this.type === jsOMS.Modules.Draw.DrawTypeEnum.LINE) {
                this.ctx.moveTo(start.x, start.y);
                this.ctx.lineTo(end.x, end.y);
            }

            this.ctx.stroke();
            // this.ctx.closePath();

            // check if undo has space
            // create backup to backup canvas
            // remove x first undos from history
            // add this step to undo
        }
    };

    jsOMS.Modules.Draw.Editor.prototype.setSize = function (size)
    {
        this.size = size;
    };

    jsOMS.Modules.Draw.Editor.prototype.setType = function (type)
    {
        this.type = type;
    };

    jsOMS.Modules.Draw.Editor.prototype.setColor = function (color)
    {
        this.color = color;
    };

    jsOMS.Modules.Draw.Editor.prototype.toImage = function (callback)
    {
        const image = new Image();
        image.onload = function ()
        {
            callback(image);
        };

        image.src = this.canvas.toDataURL('image/png');

        // return image;
    };

    jsOMS.Modules.Draw.Editor.prototype.mousePosition = function (evt)
    {
        const rect = this.canvas.getBoundingClientRect();
        return {
            x: evt.clientX - rect.left - 0.5,
            y: evt.clientY - rect.top - 0.5
        };
    };

    jsOMS.Modules.Draw.Editor.prototype.resize = function (size)
    {
        const tmpCanvas = document.createElement('canvas');
        tmpCanvas.width = this.canvas.width;
        tmpCanvas.height = this.canvas.height;

        tmpCanvas.getContext('2d').drawImage(this.canvas, 0, 0);

        this.canvas.width = size.width;
        this.canvas.height = size.height;

        this.canvas.getContext('2d').drawImage(tmpCanvas, 0, 0, tmpCanvas.width, tmpCanvas.height, 0, 0, this.canvas.width, this.canvas.height);
    };

    jsOMS.Modules.Draw.Editor.prototype.scale = function (scale)
    {
        const tmpCanvas = document.createElement('canvas');
        tmpCanvas.width = this.canvas.width;
        tmpCanvas.height = this.canvas.height;

        tmpCanvas.getContext('2d').drawImage(this.canvas, 0, 0);

        this.canvas.getContext('2d').drawImage(tmpCanvas, 0, 0, tmpCanvas.width, tmpCanvas.height, 0, 0, scale.width, scale.height);
    };
}(window.jsOMS = window.jsOMS || {}));
