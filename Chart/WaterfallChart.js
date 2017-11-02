(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.WaterfallChart = function (id)
    {
        this.chart = new jsOMS.Chart.ChartAbstract(id);

        // Setting default chart values
        this.chart.margin = {top: 5, right: 0, bottom: 0, left: 0};
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
        this.chart.subtype = 'waterfall';
    };

    jsOMS.Chart.WaterfallChart.prototype.getChart = function ()
    {
        return this.chart;
    };

    jsOMS.Chart.WaterfallChart.prototype.setData = function (data)
    {
        let dataset = [{id: 1, name: 'Dataset', points: []}],
            length = data.length,
            add = 0;

        // todo: remove value since positive and negative can be checked by looking at the diff of y-y0
        for(let i = 0; i < length - 1; i++) {
            dataset[0].points[i] = { name: data[i].name, y0: add, y: data[i].value + add };
            add += data[i].value;
        }

        dataset[0].points[length - 1] = { name: data[length - 1].name, y0: 0, y: add };

        this.chart.setData(dataset);
    };

    jsOMS.Chart.WaterfallChart.prototype.draw = function ()
    {
        let bar, svg, x, xAxis1, xAxis2, y, yAxis1, yAxis2, xGrid, yGrid, zoom, self = this;

        this.chart.calculateDimension();

        x = this.chart.createXScale('ordinal');
        y = this.chart.createYScale('linear');
        xAxis1 = this.chart.createXAxis(x);
        yAxis1 = this.chart.createYAxis(y);
        xGrid = this.chart.createXGrid(x);
        yGrid = this.chart.createYGrid(y);

        x.domain(this.chart.dataset[0].points.map(function(d) { return d.name; }));
        y.domain([0, d3.max(this.chart.dataset[0].points, function(d) { return d.y*1.05; })]);

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

        this.chart.drawText(svg);
        this.chart.drawAxis(svg, xAxis1, yAxis1);

        if (this.chart.shouldRedraw) {
            this.redraw();
        }
    };

    jsOMS.Chart.WaterfallChart.prototype.redraw = function ()
    {
        this.chart.shouldRedraw = false;
        this.chart.chartSelect.select("*").remove();
        this.draw();
    };

    jsOMS.Chart.WaterfallChart.prototype.drawData = function (svg, x, y, dataPointEnter, dataPoint)
    {
        const self = this;

        dataPoint = svg.selectAll(".dataPoint").data(this.chart.dataset[0].points, function (c)
        {
            return c.name;
        });

        dataPointEnter = dataPoint.enter().append("g")
            .attr("class", function(d) { return "dataPoint " + (d.y < d.y0 ? 'negative' : 'positive'); })
            .attr("transform", function(d) { return "translate(" + x(d.name) + ",0)"; });

        dataPointEnter.append("rect")
            .attr("y", function(d) { return y( Math.max(d.y0, d.y) ); })
            .attr("height", function(d) { return Math.abs( y(d.y0) - y(d.y) ); })
            .attr("width", x.rangeBand());

        dataPointEnter.append("text")
            .attr("x", x.rangeBand() / 2)
            .attr("y", function(d) { return y(d.y) + 5; })
            .attr("dy", function(d) { return ((d.y < d.y0) ? '-' : '') + ".75em" })
            .text(function(d) { return d.y - d.y0; });

        dataPointEnter.filter(function(d) { return d.class != "total" }).append("line")
            .attr("class", "connector")
            .attr("x1", x.rangeBand() + 5 )
            .attr("y1", function(d) { return y(d.y) } )
            .attr("x2", x.rangeBand() / ( 1 - 5) - 5 )
            .attr("y2", function(d) { return y(d.y) } );

        return [dataPointEnter, dataPoint];
    };
}(window.jsOMS = window.jsOMS || {}));
