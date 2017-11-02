(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.GroupedBarChart = function (id)
    {
        this.chart = new jsOMS.Chart.BarChart(id);
        this.chart.getChart().subtype = 'grouped';
    };

    jsOMS.Chart.GroupedBarChart.prototype.getChart = function ()
    {
        return this.chart.getChart();
    };

    jsOMS.Chart.GroupedBarChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.GroupedBarChart.prototype.draw = function ()
    {
        this.chart.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
