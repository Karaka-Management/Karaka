(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.StackedColumnChart = function (id)
    {
        this.chart = new jsOMS.Chart.ColumnChart(id);
        this.chart.getChart().subtype = 'stacked';
    };

    jsOMS.Chart.StackedColumnChart.prototype.getChart = function ()
    {
        return this.chart.getChart();
    };

    jsOMS.Chart.StackedColumnChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.StackedColumnChart.prototype.draw = function ()
    {
        this.chart.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
