(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.ColumnChart = function (id)
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
                visible: false
            },
            y: {
                visible: true
            }
        };

        this.chart.dataSettings.marker.visible = false;
        this.chart.subtype                     = 'stacked';
    };

    jsOMS.Chart.ColumnChart.prototype.getChart = function ()
    {
        return this.chart;
    };

    jsOMS.Chart.ColumnChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.ColumnChart.prototype.draw = function ()
    {
        let rect, svg, x, xAxis1, xAxis2, y, yAxis1, yAxis2, xGrid, yGrid, zoom, self = this;

        if (this.chart.subtype === 'grouped') {
            this.chart.axis.y.max = d3.max(this.chart.dataset, function (layer)
            {
                return d3.max(layer.points, function (d)
                {
                    return d.y;
                });
            });
        } else {
            this.chart.axis.y.max = d3.max(this.chart.dataset, function (layer)
            {
                return d3.max(layer.points, function (d)
                {
                    return d.y0 + d.y;
                });
            });
        }

        this.chart.calculateDimension();

        x = this.chart.createXScale('ordinal');
        y = this.chart.createYScale('linear');
        xAxis1 = this.chart.createXAxis(x);
        yAxis1 = this.chart.createYAxis(y);
        xGrid = this.chart.createXGrid(x);
        yGrid = this.chart.createYGrid(y);

        x.domain(d3.range(this.chart.dataset[0].points.length)).rangeRoundBands([0, this.chart.dimension.width - this.chart.margin.right - this.chart.margin.left], .1);
        y.domain([0, this.chart.axis.y.max + 1]);

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
        this.chart.drawMarker(svg, x, y, dataPointEnter, dataPoint);
        this.chart.drawLegend(svg, dataPointEnter, dataPoint);
        this.chart.drawText(svg);
        this.chart.drawAxis(svg, xAxis1, yAxis1);

        if (this.chart.shouldRedraw) {
            this.redraw();
        }
    };

    jsOMS.Chart.ColumnChart.prototype.redraw = function ()
    {
        this.chart.shouldRedraw = false;
        this.chart.chartSelect.select("*").remove();
        this.draw();
    };

    jsOMS.Chart.ColumnChart.prototype.drawData = function (svg, x, y, dataPointEnter, dataPoint)
    {
        const self = this;
        let rect;

        dataPoint = svg.selectAll(".dataPoint").data(this.chart.dataset, function (c)
        {
            return c.id;
        });

        dataPointEnter = dataPoint.enter().append("g").attr("class", "dataPoint")
            .style("fill", function (d)
            {
                return self.chart.color(d.name);
            });

        rect = dataPointEnter.selectAll("rect")
            .data(function (d)
            {
                return d.points;
            })
            .enter().append("rect")
            .attr("x", function (d)
            {
                return x(d.x);
            })
            .attr("y", this.chart.dimension.height - this.chart.margin.top - this.chart.margin.bottom)
            .attr("width", x.rangeBand())
            .attr("height", 0);

        if(this.chart.subtype === 'stacked') {
            rect.transition()
                .delay(function (d, i)
                {
                    return i * 10;
                })
                .attr("y", function (d)
                {
                    return y(d.y0 + d.y);
                })
                .attr("height", function (d)
                {
                    return y(d.y0) - y(d.y0 + d.y);
                });
        } else {
            rect.transition()
                .duration(500)
                .delay(function (d, i)
                {
                    return i * 10;
                })
                .attr("x", function (d, i, j)
                {
                    return x(d.x) + x.rangeBand() / self.chart.dataset.length * j;
                })
                .attr("width", x.rangeBand() /self.chart.dataset.length)
                .transition()
                .attr("y", function (d)
                {
                    return y(d.y);
                })
                .attr("height", function (d)
                {
                    return self.chart.dimension.height - self.chart.margin.top - self.chart.margin.bottom - y(d.y);
                });
        }

        return [dataPointEnter, dataPoint];
    };

    jsOMS.Chart.ColumnChart.prototype.transitionGrouped = function (x, y, rect, yMin, yMax)
    {
        y.domain([yMin, yMax]);

        rect.transition()
            .duration(500)
            .delay(function (d, i)
            {
                return i * 10;
            })
            .attr("x", function (d, i, j)
            {
                return x(d.x) + x.rangeBand() / n * j;
            })
            .attr("width", x.rangeBand() / n)
            .transition()
            .attr("y", function (d)
            {
                return y(d.y);
            })
            .attr("height", function (d)
            {
                return self.chart.dimension.height - self.chart.margin.top - self.chart.margin.bottom - y(d.y);
            });
    };

    jsOMS.Chart.ColumnChart.prototype.transitionStacked = function (x, y, rect, yMin, yMax)
    {
        y.domain([yMin, yMax]);

        rect.transition()
            .duration(500)
            .delay(function (d, i)
            {
                return i * 10;
            })
            .attr("y", function (d)
            {
                return y(d.y0 + d.y);
            })
            .attr("height", function (d)
            {
                return y(d.y0) - y(d.y0 + d.y);
            })
            .transition()
            .attr("x", function (d)
            {
                return x(d.x);
            })
            .attr("width", x.rangeBand());
    };
}(window.jsOMS = window.jsOMS || {}));
