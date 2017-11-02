/**
 * Linear regression class.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    /** @namespace jsOMS.Math.Stochastic.Forecast.LinearRegression */
    jsOMS.Autoloader.defineNamespace('jsOMS.Math.Stochastic.Forecast.LinearRegression');

    jsOMS.Math.Stochastic.Forecast.LinearRegression.getLinearRegresseion = function (x, y)
    {
        let count = x.length,
            meanX = jsOMS.Math.Stochastic.Average.arithmeticMean(x),
            meanY = jsOMS.Math.Stochastic.Average.arithmeticMean(y),
            sum1  = 0,
            sum2  = 0,
            b0, b1;

        for (let i = 0; i < count; i++) {
            sum1 += (y[i] - meanY) * (x[i] - meanX);
            sum2 += Math.pow(x[i] - meanX, 2);
        }

        b1 = sum1 / sum2;
        b0 = meanY - b1 * meanX;

        return {b0: b0, b1: b1};
    };
}(window.jsOMS = window.jsOMS || {}));