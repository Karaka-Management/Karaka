var MathEvaluator = function () {

};

MathEvaluator.prototype.attach = function () {

};

MathEvaluator.prototype.detach = function () {

};

MathEvaluator.prototype.trigger = function (node) {
    var value = node.value;

    if (!value.slice(0, 1) == '=') {
        return;
    }

    var processor = new MathProcessor();
    return processor.parse(value);
};
