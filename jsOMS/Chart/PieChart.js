(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.PieChart = function (id)
    {
        this.chart = new jsOMS.Chart.ChartAbstract(id);

        // Setting default chart values
        this.chart.margin = {top: 5, right: 0, bottom: 0, left: 0};
        /** global: d3 */
        this.chart.color  = d3.scale.category10();
        this.chart.dataSettings.style.strokewidth = 1;
        this.chart.dataSettings.style.padding = 3;
        this.chart.subtype = 'pie';
    };

    jsOMS.Chart.PieChart.prototype.getChart = function ()
    {
        return this.chart;
    };

    jsOMS.Chart.PieChart.prototype.draw = function ()
    {
        let svg, arc;

        this.chart.calculateDimension();

        svg = this.chart.chartSelect.append("svg")
            .attr("width", this.chart.dimension.width)
            .attr("height", this.chart.dimension.height)
            .append("g").attr("transform", "translate("
                + (this.chart.margin.left) + ","
                + (this.chart.margin.top) + ")");

        let dataPoint = null, 
            dataPointEnter = null,
            temp       = this.drawData(svg, dataPointEnter, dataPoint);
        dataPointEnter = temp[0];
        dataPoint      = temp[1];

        // todo: create own legend drawing
        this.chart.drawLegend(svg, dataPointEnter, dataPoint);
        this.chart.drawText(svg);

        if (this.chart.shouldRedraw) {
            this.redraw();
        }
    };

    jsOMS.Chart.PieChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.PieChart.prototype.redraw = function ()
    {
        this.chart.shouldRedraw = false;
        this.chart.chartSelect.select("*").remove();
        this.draw();
    };

    jsOMS.Chart.PieChart.prototype.drawData = function (svg, dataPointEnter, dataPoint)
    {
        const self = this;
        let pie  = d3.layout.pie()
                .sort(null)
                .value(function (d)
                {
                    return d.value;
                }),
            radius = (
            Math.min(this.chart.dimension.width, this.chart.dimension.height) / 2
            - Math.max(this.chart.margin.right + this.chart.margin.left,
                this.chart.margin.top + this.chart.margin.bottom)
            ),
            innerRadius = radius - radius*self.chart.dataSettings.style.strokewidth,
            arc = d3.svg.arc()
                .outerRadius(function() { return radius; })
                .innerRadius(function() { return innerRadius; });

        dataPoint = svg.selectAll(".dataPoint").data(this.chart.dataset);
        
        dataPoint.enter().append("g").attr("class", "dataPoint");
        
        dataPointEnter = dataPoint.selectAll("path")
            .data(function (d)
            {
                return pie(d.points);
            }).enter().append('path')
            .attr("transform", "translate("
                + ((this.chart.dimension.width - this.chart.margin.left - this.chart.margin.right) / 2 ) + ","
                + ((this.chart.dimension.height - this.chart.margin.bottom - this.chart.margin.top) / 2) + ")")
            .attr('fill', function (d)
            {
                return self.chart.color(d.data.name);
            })
            .attr('d', arc)
            .style('stroke', '#fff')
            .style('stroke-width', this.chart.dataSettings.style.padding);

        return [dataPointEnter, dataPoint];
    };
}(window.jsOMS = window.jsOMS || {}));
