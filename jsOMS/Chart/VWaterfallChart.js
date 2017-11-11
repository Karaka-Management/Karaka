(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.VWaterfallChart = function (id)
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
        this.chart.subtype = 'vwaterfall';
    };

    jsOMS.Chart.VWaterfallChart.prototype.getChart = function ()
    {
        return this.chart;
    };

    jsOMS.Chart.VWaterfallChart.prototype.setData = function (data)
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

    jsOMS.Chart.VWaterfallChart.prototype.draw = function ()
    {
        let bar, svg, x, xAxis1, xAxis2, y, yAxis1, yAxis2, xGrid, yGrid, zoom, self = this;

        this.chart.calculateDimension();

        x = this.chart.createXScale('linear');
        y = this.chart.createYScale('ordinal');
        xAxis1 = this.chart.createXAxis(x);
        yAxis1 = this.chart.createYAxis(y);
        xGrid = this.chart.createXGrid(x);
        yGrid = this.chart.createYGrid(y);

        x.domain([0, d3.max(this.chart.dataset[0].points, function(d) { return d.y*1.05; })]);
        y.domain(this.chart.dataset[0].points.map(function(d) { return d.name; }));

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

        this.chart.drawText(svg);
        this.chart.drawAxis(svg, xAxis1, yAxis1);

        if (this.chart.shouldRedraw) {
            this.redraw();
        }
    };

    jsOMS.Chart.VWaterfallChart.prototype.redraw = function ()
    {
        this.chart.shouldRedraw = false;
        this.chart.chartSelect.select("*").remove();
        this.draw();
    };

    jsOMS.Chart.VWaterfallChart.prototype.drawData = function (svg, x, y, dataPointEnter, dataPoint)
    {
        const self = this;

        dataPoint = svg.selectAll(".dataPoint").data(this.chart.dataset[0].points, function (c)
        {
            return c.name;
        });

        dataPointEnter = dataPoint.enter().append("g")
            .attr("class", function(d) { return "dataPoint " + (d.y < d.y0 ? 'negative' : 'positive'); })
            .attr("transform", function(d) { return "translate(0," + y(d.name) + ")"; });

        dataPointEnter.append("rect")
            .attr("x", function(d) { return x( Math.min(d.y0, d.y) ); })
            .attr("width", function(d) { return Math.abs( x(d.y0) - x(d.y) ); })
            .attr("height", y.rangeBand());

        dataPointEnter.filter(function(d) { return d.class != "total" }).append("line")
            .attr("class", "connector")
            .attr("x1", y.rangeBand() + 5 )
            .attr("y1", function(d) { return x(d.y) } )
            .attr("x2", y.rangeBand() / ( 1 - 5) - 5 )
            .attr("y2", function(d) { return x(d.y) } );

        return [dataPointEnter, dataPoint];
    };
}(window.jsOMS = window.jsOMS || {}));
