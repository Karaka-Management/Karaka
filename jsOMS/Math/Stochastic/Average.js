/**
 * Average class.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    
    /** @namespace jsOMS.Math.Stochastic.Average */
    jsOMS.Autoloader.defineNamespace('jsOMS.Math.Stochastic.Average');

    jsOMS.Math.Stochastic.Average.arithmeticMean = function (values, offset = 0)
    {
        Array.sort(values);
        let length = values.length;

        if (offset > 0) {
            values = Array.splice(offset, length - offset);
        }

        if (length === 0) {
            throw 'Division zero';
        }

        return values.reduce((a, b) => a + b, 0) / length;
    };
}(window.jsOMS = window.jsOMS || {}));