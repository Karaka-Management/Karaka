(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.StackedBarChart = function (id)
    {
        this.chart = new jsOMS.Chart.BarChart(id);
        this.chart.getChart().subtype = 'stacked';
    };

    jsOMS.Chart.StackedBarChart.prototype.getChart = function ()
    {
        return this.chart.getChart();
    };

    jsOMS.Chart.StackedBarChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.StackedBarChart.prototype.draw = function ()
    {
        this.chart.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
