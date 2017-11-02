(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.StackedAreaChart = function (id)
    {
        this.chart = new jsOMS.Chart.LineChart(id);
        this.chart.getChart().dataSettings.marker.visible = false;
        this.chart.getChart().subtype = 'stacked';
    };

    jsOMS.Chart.StackedAreaChart.prototype.getChart = function ()
    {
        return this.chart.getChart();
    };

    jsOMS.Chart.StackedAreaChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.StackedAreaChart.prototype.draw = function ()
    {
        return this.chart.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
