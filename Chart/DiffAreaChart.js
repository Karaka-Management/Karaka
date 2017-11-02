(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.DiffAreaChart = function (id)
    {
        this.chart = new jsOMS.Chart.LineChart(id);
        this.chart.getChart().dataSettings.marker.visible = false;
        this.chart.getChart().subtype = 'diffarea';
    };

    jsOMS.Chart.DiffAreaChart.prototype.getChart = function ()
    {
        return this.chart.getChart();
    };

    jsOMS.Chart.DiffAreaChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.DiffAreaChart.prototype.draw = function ()
    {
        return this.chart.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
