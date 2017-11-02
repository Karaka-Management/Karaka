(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.OhlcChart = function (id)
    {
        this.chart = new jsOMS.Chart.CandlestickChart(id);
        this.chart.getChart().subtype = 'ohlc';
    };

    jsOMS.Chart.OhlcChart.prototype.getChart = function ()
    {
        return this.chart.getChart();
    };

    jsOMS.Chart.OhlcChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.OhlcChart.prototype.draw = function ()
    {
        return this.chart.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
