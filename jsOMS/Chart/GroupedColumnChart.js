(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.GroupedColumnChart = function (id)
    {
        this.chart = new jsOMS.Chart.ColumnChart(id);
        this.chart.getChart().subtype = 'grouped';
    };

    jsOMS.Chart.GroupedColumnChart.prototype.getChart = function ()
    {
        return this.chart.getChart();
    };

    jsOMS.Chart.GroupedColumnChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.GroupedColumnChart.prototype.draw = function ()
    {
        this.chart.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
