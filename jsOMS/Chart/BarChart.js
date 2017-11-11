(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.BarChart = function (id)
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

    jsOMS.Chart.BarChart.prototype.getChart = function ()
    {
        return this.chart;
    };

    jsOMS.Chart.BarChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.BarChart.prototype.draw = function ()
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

        x = this.chart.createXScale('linear');
        y = this.chart.createYScale('ordinal');
        xAxis1 = this.chart.createXAxis(x);
        yAxis1 = this.chart.createYAxis(y);
        xGrid = this.chart.createXGrid(x);
        yGrid = this.chart.createYGrid(y);

        x.domain([0, this.chart.axis.y.max + 1]);
        y.domain(d3.range(this.chart.dataset[0].points.length)).rangeRoundBands([0, this.chart.dimension.height - this.chart.margin.top - this.chart.margin.bottom], .1);

        svg = this.chart.chartSelect.append("svg")
            .attr("width", this.chart.dimension.width)
            .attr("height", this.chart.dimension.height)
            .append("g").attr("transform", "translate("
                + (this.chart.margin.left) + ","
                + (this.chart.margin.top) + ")");

        this.chart.drawGrid(svg, xGrid, yGrid);

        let dataPoint = null, 
            dataPointEnter = null,
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

    jsOMS.Chart.BarChart.prototype.redraw = function ()
    {
        this.chart.shouldRedraw = false;
        this.chart.chartSelect.select("*").remove();
        this.draw();
    };

    jsOMS.Chart.BarChart.prototype.drawData = function (svg, x, y, dataPointEnter, dataPoint)
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
            .attr("y", function (d)
            {
                return y(d.x);
            })
            .attr("x", 0)
            .attr("width", 0)
            .attr("height", y.rangeBand());

        if(this.chart.subtype === 'stacked') {
            rect.transition()
                .delay(function (d, i)
                {
                    return i * 10;
                })
                .attr("x", function (d)
                {
                    return x(d.y0);
                })
                .attr("width", function (d)
                {
                    return x(d.y);
                });
        } else {
            rect.transition()
                .duration(500)
                .delay(function (d, i)
                {
                    return i * 10;
                })
                .attr("y", function (d, i, j)
                {
                    return y(d.x) + y.rangeBand() / self.chart.dataset.length * j;
                })
                .attr("height", y.rangeBand() /self.chart.dataset.length)
                .transition()
                .attr("x", 0)
                .attr("width", function (d)
                {
                    return x(d.y);
                });
        }

        return [dataPointEnter, dataPoint];
    };
}(window.jsOMS = window.jsOMS || {}));
