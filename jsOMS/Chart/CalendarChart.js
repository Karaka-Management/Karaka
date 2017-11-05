(function (jsOMS)
{
    "use strict";
    
    jsOMS.Chart.CalendarChart = function (id)
    {
        this.chart = new jsOMS.Chart.ChartAbstract(id);

        // Setting default chart values
        this.chart.margin = {top: 5, right: 0, bottom: 0, left: 0};
        this.chart.color  = d3.scale.quantize()
            .domain([-.05, .05])
            .range(d3.range(11).map(function(d) { return "q" + d + "-11"; }));

        this.chart.subtype = 'calendar';
    };

    jsOMS.Chart.CalendarChart.prototype.getChart = function ()
    {
        return this.chart;
    };

    jsOMS.Chart.CalendarChart.prototype.setData = function (data)
    {
        this.chart.setData(data);
    };

    jsOMS.Chart.CalendarChart.prototype.draw = function ()
    {
        let percent = d3.format(".1%"),
            format = d3.time.format("%Y-%m-%d"),
            svg, self = this;

        this.chart.calculateDimension();
        this.chart.cellSize = Math.min(this.chart.dimension.width / (12*5), this.chart.dimension.height / (8));

        document.getElementById(this.chart.chartId).style.height = (this.chart.dimension.height * this.chart.dataset.length) + 'px';

        svg = this.chart.chartSelect.selectAll('svg').data(this.chart.dataset).enter().append("svg")
            .attr("width", this.chart.dimension.width)
            .attr("height",  this.chart.dimension.height)
            .attr("class", "RdYlGn")
        .append("g")
            .attr("transform", "translate(" 
            + ((this.chart.dimension.width - this.chart.cellSize * 53) / 2)
            + "," + (this.chart.dimension.height - this.chart.cellSize * 7 - 1) + ")");

        svg.append("text")
            .attr("transform", "translate(-6," + this.chart.cellSize * 3.5 + ")rotate(-90)")
            .style("text-anchor", "middle")
            .text(function(d) { return d.name; });

        let rect = svg.selectAll(".day")
            .data(function(d) { return d3.time.days(new Date(parseInt(d.name), 0, 1), new Date(parseInt(d.name) + 1, 0, 1)); })
        .enter().append("rect")
            .attr("class", "day")
            .attr("width", this.chart.cellSize)
            .attr("height", this.chart.cellSize)
            .attr("x", function(d) { return d3.time.weekOfYear(d) * self.chart.cellSize; })
            .attr("y", function(d) { return d.getDay() * self.chart.cellSize; })
            .datum(format);

        rect.append("title")
            .text(function(d) { });

        svg.selectAll(".month")
            .data(function(d) { return d3.time.months(new Date(parseInt(d.name), 0, 1), new Date(parseInt(d.name) + 1, 0, 1)); })
        .enter().append("path")
            .attr("class", "month")
            .attr("d", function(t0) {
                let t1 = new Date(t0.getFullYear(), t0.getMonth() + 1, 0),
                    d0 = t0.getDay(), w0 = d3.time.weekOfYear(t0),
                    d1 = t1.getDay(), w1 = d3.time.weekOfYear(t1);

                return "M" + (w0 + 1) * self.chart.cellSize + "," + d0 * self.chart.cellSize
                    + "H" + w0 * self.chart.cellSize + "V" + 7 * self.chart.cellSize
                    + "H" + w1 * self.chart.cellSize + "V" + (d1 + 1) * self.chart.cellSize
                    + "H" + (w1 + 1) * self.chart.cellSize + "V" + 0
                    + "H" + (w0 + 1) * self.chart.cellSize + "Z";
            });

        // todo: fix the following data filter etc. this is way to much work and slow
        rect.filter(function(d) { 
            let year = d.split('-')[0],
                length = self.chart.dataset.length;

                for(let i = 0; i < length; i++) {
                    if(self.chart.dataset[i].name != year) {
                        continue;
                    }

                    let dataLength = self.chart.dataset[i].points.length;

                    for(let j = 0; j < dataLength; j++) {
                        if(self.chart.dataset[i].points[j].x === d) {
                            return true;
                        }
                    }

                    return false;
                }

              return false; 
        })
            .attr("class", function(d) {
                let year = d.split('-')[0],
                length = self.chart.dataset.length;
                
                for(let i = 0; i < length; i++) {
                    if(self.chart.dataset[i].name != year) {
                        continue;
                    }

                    let dataLength = self.chart.dataset[i].points.length;

                    for(let j = 0; j < dataLength; j++) {
                        if(self.chart.dataset[i].points[j].x === d) {
                             return "day " + self.chart.color(self.chart.dataset[i].points[j].y); 
                        }
                    }

                    throw "Should not happen";
                }
            })
            .select("title")
            .text(function(d) {
                let year = d.split('-')[0],
                length = self.chart.dataset.length;
                
                for(let i = 0; i < length; i++) {
                    if(self.chart.dataset[i].name != year) {
                        continue;
                    }

                    let dataLength = self.chart.dataset[i].points.length;

                    for(let j = 0; j < dataLength; j++) {
                        if(self.chart.dataset[i].points[j].x === d) {
                             return d + ": " + self.chart.dataset[i].points[j].y;
                        }
                    }

                    throw "Should not happen";
                }
            });
    };

    jsOMS.Chart.CalendarChart.prototype.redraw = function ()
    {
        this.chart.shouldRedraw = false;
        this.chart.chartSelect.select("*").remove();
        this.draw();
    };
}(window.jsOMS = window.jsOMS || {}));
