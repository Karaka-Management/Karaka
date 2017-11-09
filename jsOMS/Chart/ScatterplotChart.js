(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.ScatterplotChart = function (id)
    {
        this.chart = new jsOMS.Chart.ChartAbstract(id);

        // Setting default chart values
        this.chart.margin = {top: 5, right: 0, bottom: 0, left: 0};
        /** global: d3 */
        this.chart.color  = d3.scale.category10();
        this.chart.axis   = {
            x: {
                visible: true,
                label: {
                    visible: true,
                    text: 'X-Axis',
                    position: "center",
                    anchor: 'middle'
                },
                tick: {
                    prefix: '',
                    orientation: 'bottom',
                    size: 7
                },
                min: 0,
                max: 0
            },
            y: {
                visible: true,
                label: {
                    visible: true,
                    text: 'Y-Axis',
                    position: 'center',
                    anchor: 'middle'
                },
                tick: {
                    prefix: '',
                    orientation: 'bottom',
                    size: 7
                },
                min: 0,
                max: 0
            }
        };

        this.chart.grid = {
            x: {
                visible: true
            },
            y: {
                visible: true
            }
        };
        this.chart.subtype = 'scatterplot';
    };

    jsOMS.Chart.ScatterplotChart.prototype.getChart = function ()
    {
        return this.chart;
    };

    jsOMS.Chart.ScatterplotChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.ScatterplotChart.prototype.draw = function ()
    {
        let bar, svg, x, xAxis1, xAxis2, y, yAxis1, yAxis2, xGrid, yGrid, zoom, self = this;

        this.chart.calculateDimension('linear');

        x = this.chart.createXScale('linear');
        y = this.chart.createYScale('linear');
        xAxis1 = this.chart.createXAxis(x);
        yAxis1 = this.chart.createYAxis(y);
        xGrid = this.chart.createXGrid(x);
        yGrid = this.chart.createYGrid(y);

        x.domain([this.chart.axis.x.min, this.chart.axis.x.max + 1]);
        y.domain([this.chart.axis.y.min - 1, this.chart.axis.y.max + 1]);

        svg = this.chart.chartSelect.append("svg")
            .attr("width", this.chart.dimension.width)
            .attr("height", this.chart.dimension.height)
            .append("g").attr("transform", "translate("
                + (this.chart.margin.left) + ","
                + (this.chart.margin.top) + ")");

        this.chart.drawGrid(svg, xGrid, yGrid);
        
        let dataPoint, dataPointEnter,
            temp       = this.drawData(svg, x, y, dataPointEnter, dataPoint);
        dataPointEnter = temp[0];
        dataPoint      = temp[1];

        this.chart.drawLegend(svg, dataPointEnter, dataPoint);
        this.chart.drawText(svg);
        this.chart.drawAxis(svg, xAxis1, yAxis1);

        if (this.chart.shouldRedraw) {
            this.redraw();
        }
    };

    jsOMS.Chart.ScatterplotChart.prototype.redraw = function ()
    {
        this.chart.shouldRedraw = false;
        this.chart.chartSelect.select("*").remove();
        this.draw();
    };

    jsOMS.Chart.ScatterplotChart.prototype.drawData = function (svg, x, y, dataPointEnter, dataPoint)
    {
        const self = this;

        dataPoint = svg.selectAll(".dataPoint").data(this.chart.dataset, function (c)
        {
            return c.id;
        });

        dataPointEnter = dataPoint.enter().append("g")
        .attr("class", "dataPoint")
        .style("fill", function(d) { return self.chart.color(d.name); });

        dataPointEnter.selectAll("circle")
            .data(function (d)
            {
                return d.points;
            })
            .enter().append("circle")
            .attr("class", "dataPoint")
            .attr("r", function(d) { return d.y0; })
            .attr("cx", function(d) { return x(d.x); })
            .attr("cy", function(d) { return y(d.y); });

        return [dataPointEnter, dataPoint];
    };
}(window.jsOMS = window.jsOMS || {}));
