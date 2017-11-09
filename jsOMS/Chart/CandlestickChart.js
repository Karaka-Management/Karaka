(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.CandlestickChart = function (id)
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
            },
            y0: {
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
        this.chart.subtype = 'candlestick';
    };

    jsOMS.Chart.CandlestickChart.prototype.getChart = function ()
    {
        return this.chart;
    };

    jsOMS.Chart.CandlestickChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.CandlestickChart.prototype.draw = function ()
    {
        let bar, svg, x, xAxis1, xAxis2, y, yAxis1, yAxis2, xGrid, yGrid, zoom, self = this;

        let mm = 50;

        this.chart.calculateDimension();

        x = this.chart.createXScale('linear');
        y = this.chart.createYScale('linear');
        xAxis1 = this.chart.createXAxis(x);
        yAxis1 = this.chart.createYAxis(y);
        xGrid = this.chart.createXGrid(x);
        yGrid = this.chart.createYGrid(y);

        x.domain([this.chart.axis.x.min - 1, this.chart.axis.x.max + 1]);
        y.domain([this.chart.axis.y0.min - 1, this.chart.axis.y.max + 1]);

        svg = this.chart.chartSelect.append("svg")
            .attr("width", this.chart.dimension.width)
            .attr("height", this.chart.dimension.height)
            .append("g").attr("transform", "translate("
                + (this.chart.margin.left) + ","
                + (this.chart.margin.top) + ")");

        this.chart.drawGrid(svg, xGrid, yGrid);

        if(this.chart.subtype === 'candlestick') {
            svg.selectAll("rect")
            .data(this.chart.dataset[0].points)
            .enter().append("svg:rect")
            .attr("x", function(d) { return x(d.x)-0.5*mm/2; })
            .attr("y", function(d) {return y(Math.max(d.open, d.close));})		  
            .attr("height", function(d) { return Math.max(1, y(Math.min(d.open, d.close))-y(Math.max(d.open, d.close)));})
            .attr("width", function(d) { return 0.5 * mm; })
            .attr("fill",function(d) { return d.open > d.close ? "red" : "green" ;});
        } else {
            let datapoint = svg.selectAll("rect")
            .data(this.chart.dataset[0].points)
            .enter();
            
            datapoint.append("svg:rect")
            .attr("x", function(d) { return x(d.x)-0.25*mm/2; })
            .attr("y", function(d) {return y(d.open);})		  
            .attr("height", function(d) { return 1;})
            .attr("width", function(d) { return 0.25 * mm/2; })
            .attr("fill",function(d) { return d.open > d.close ? "red" : "green" ;});
            
            datapoint.append("svg:rect")
            .attr("x", function(d) { return x(d.x); })
            .attr("y", function(d) {return y(d.close);})		  
            .attr("height", function(d) { return 1;})
            .attr("width", function(d) { return 0.25 * mm/2; })
            .attr("fill",function(d) { return d.open > d.close ? "red" : "green" ;});
        }

        svg.selectAll("line.stem")
          .data(this.chart.dataset[0].points)
          .enter().append("svg:line")
          .attr("class", "stem")
          .attr("x1", function(d) { return x(d.x);})
          .attr("x2", function(d) { return x(d.x);})		    
          .attr("y1", function(d) { return y(d.y);})
          .attr("y2", function(d) { return y(d.y0); })
          .attr("stroke", function(d){ return d.open > d.close ? "red" : "green"; });

        this.chart.drawText(svg);
        this.chart.drawAxis(svg, xAxis1, yAxis1);

        if (this.chart.shouldRedraw) {
            this.redraw();
        }
    };

    jsOMS.Chart.CandlestickChart.prototype.redraw = function ()
    {
        this.chart.shouldRedraw = false;
        this.chart.chartSelect.select("*").remove();
        this.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
