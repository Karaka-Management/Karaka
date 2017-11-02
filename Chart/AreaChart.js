(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.AreaChart = function (id)
    {
        this.chart = new jsOMS.Chart.LineChart(id);
        this.chart.getChart().subtype = 'area';
    };

    jsOMS.Chart.AreaChart.prototype.getChart = function ()
    {
        return this.chart.getChart();
    };

    jsOMS.Chart.AreaChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.AreaChart.prototype.draw = function ()
    {
        return this.chart.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
