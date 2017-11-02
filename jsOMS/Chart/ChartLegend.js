(function (jsOMS) {
    "use strict";

    jsOMS.Chart.Legend = function () {
        this.position = {x: 0, y: 0};
        this.relative = true;
        this.horizontal = false;
        this.visible = true;
        this.labels = []; // {title, color, marker}
    };

    jsOMS.Chart.Legend.prototype.addLabel = function(label) {
        this.labels.push(label);
    };

    jsOMS.Chart.Legend.prototype.setVisibility = function(visibility) {
        this.visible = visibility;
    };

    jsOMS.Chart.Legend.prototype.getVisibility = function() {
        return this.visible;
    };

    jsOMS.Chart.Legend.prototype.setPosition = function(position) {
        this.position = position;
    };

    jsOMS.Chart.Legend.prototype.getPosition = function() {
        return this.position;
    };

    jsOMS.Chart.Legend.prototype.setRelative = function(relative) {
        this.relative = relative;
    };

    jsOMS.Chart.Legend.prototype.isRelative = function() {
        return this.relative;
    };

    jsOMS.Chart.Legend.prototype.setHorizontal = function(horizontal) {
        this.horizontal = horizontal;
    };

    jsOMS.Chart.Legend.prototype.isHorizontal = function() {
        return this.horizontal;
    };


}(window.jsOMS = window.jsOMS || {}));
