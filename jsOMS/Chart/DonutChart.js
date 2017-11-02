(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.DonutChart = function (id)
    {
        this.chart = new jsOMS.Chart.PieChart(id);

        // Setting default chart values
        this.chart.getChart().dataSettings.style.strokewidth = 0.3;
        this.chart.getChart().subtype = 'donut';
    };

    jsOMS.Chart.DonutChart.prototype.getChart = function ()
    {
        return this.chart.getChart();
    };

    jsOMS.Chart.DonutChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.DonutChart.prototype.draw = function ()
    {
        this.chart.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
