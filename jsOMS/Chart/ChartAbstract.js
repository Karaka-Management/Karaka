(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.Chart */
    jsOMS.Autoloader.defineNamespace('jsOMS.Chart');
    
    jsOMS.Chart.ChartAbstract = function (id)
    {
        /** global: d3 */
        this.chartId = id;
        this.chartSelect = d3.select('#' + this.chartId);

        this.title = {
            visible: true,
            text: "",
            anchor: "middle",
            position: "center"
        };
        this.subtitle = {
            visible: true,
            text: "",
            anchor: "middle",
            position: "center"
        };
        this.footer = {
            visible: true,
            text: "",
            anchor: "end",
            position: "right"
        };
        this.legend = {
            visible: true
        };
        this.color = d3.scale.category10();
        this.dataset = [];
        this.dataSettings = {
            style: {
                strokewidth: 3,
                padding: 0
            },
            marker: {
                visible: true,
                type: 'circle'
            },
            info: {
                visible: true
            },
            extremum: {
                visible: false
            },
            values: {
                visible: false
            },
            dataset: true, /* show dataset below */
            interpolate: "linear" /* splines interpolation? */
        };

        this.dimension = {width: 0, height: 0};
        this.margin = {top: 0, right: 0, bottom: 0, left: 0};

        this.axis = {};
        this.grid = {};
        this.subtype = '';

        this.clean();
    };

    jsOMS.Chart.ChartAbstract.prototype.calculateHorizontalPosition = function (position)
    {
        let x = 0;
        if (position === 'center') {
            x = (
                    this.dimension.width
                    - this.margin.right
                    - this.margin.left
                ) / 2;
        } else if (position === 'left') {
            x = 0;
        } else if (position === 'right') {
            x = this.dimension.width - this.margin.right - this.margin.left;
        }

        return x;
    };

    jsOMS.Chart.ChartAbstract.prototype.calculateVerticalPosition = function (position)
    {
        let y = 0;
        if (position === 'center') {
            y = -(this.dimension.height
                    - this.margin.top
                    - this.margin.bottom
                ) / 2;
        } else if (position === 'bottom') {
            y = -(this.dimension.height
                - this.margin.top
                - this.margin.bottom
            );
        } else if (position === 'top') {
            y = -this.margin.top;
        }

        return y;
    };

    jsOMS.Chart.ChartAbstract.prototype.setColor = function (color)
    {
        this.color = color;
    };

    jsOMS.Chart.ChartAbstract.prototype.getColor = function ()
    {
        return this.color;
    };

    jsOMS.Chart.ChartAbstract.prototype.setAxis = function (id, axis)
    {
        this.axis[id] = jsOMS.merge(this.axis[id], axis);

        // Setting axis dimensions in case dataset existss
        if (Object.keys(this.dataset).length > 0) {
            this.axis[id].max = d3.max(this.dataset, function (m)
            {
                return d3.max(m.points, function (d)
                {
                    return d[id];
                });
            });
        }
    };

    jsOMS.Chart.ChartAbstract.prototype.setMargin = function (top, right, bottom, left)
    {
        this.margin = {top: top, right: right, bottom: bottom, left: left};
    };

    jsOMS.Chart.ChartAbstract.prototype.setDimension = function (width, height)
    {
        this.dimension = {width: width, height: height};
    };

    jsOMS.Chart.ChartAbstract.prototype.getDimension = function ()
    {
        return this.dimension;
    };

    jsOMS.Chart.ChartAbstract.prototype.setDimensionRelative = function (relative)
    {
        this.relative = relative;
    };

    jsOMS.Chart.ChartAbstract.prototype.setTitle = function (title)
    {
        this.title = jsOMS.merge(this.title, title);
    };

    jsOMS.Chart.ChartAbstract.prototype.getTitle = function ()
    {
        return this.title;
    };

    jsOMS.Chart.ChartAbstract.prototype.setSubtitle = function (subtitle)
    {
        this.subtitle = subtitle;
    };

    jsOMS.Chart.ChartAbstract.prototype.getSubtitle = function ()
    {
        return this.subtitle;
    };

    jsOMS.Chart.ChartAbstract.prototype.setFooter = function (footer)
    {
        this.footer = footer;
    };

    jsOMS.Chart.ChartAbstract.prototype.getFooter = function ()
    {
        return this.footer;
    };

    jsOMS.Chart.ChartAbstract.prototype.setSubtype = function (subtype)
    {
        this.subtype = subtype;
    };

    jsOMS.Chart.ChartAbstract.prototype.getSubtype = function ()
    {
        return this.subtype;
    };

    jsOMS.Chart.ChartAbstract.prototype.setLegend = function (legend)
    {
        this.legend = jsOMS.merge(this.legend, legend);
    };

    jsOMS.Chart.ChartAbstract.prototype.getLegend = function ()
    {
        if (!this.legend) {
            this.legend = new jsOMS.Chart.ChartAbstractLegend();
        }

        return this.legend;
    };

    jsOMS.Chart.ChartAbstract.prototype.addDataset = function (dataset)
    {
        this.dataset.push(dataset);

        this.findAxisDomain();
    };

    jsOMS.Chart.ChartAbstract.prototype.setData = function (data)
    {
        this.dataset = data;

        this.findAxisDomain();
    };

    jsOMS.Chart.ChartAbstract.prototype.findAxisDomain = function ()
    {
        for (let id in this.axis) {
            if(!this.axis.hasOwnProperty(id)) {
                continue;
            }

            this.axis[id].max = d3.max(this.dataset, function (m)
            {
                return d3.max(m.points, function (d)
                {
                    return d[id];
                });
            });

            this.axis[id].min = d3.min(this.dataset, function (d)
            {
                return d3.min(d.points, function (t)
                {
                    return t[id];
                });
            });
        }
    };

    jsOMS.Chart.ChartAbstract.prototype.getData = function ()
    {
        return this.dataset;
    };

    jsOMS.Chart.ChartAbstract.prototype.drawLegend = function (svg, dataPointEnter, dataPoint)
    {
        const self = this;

        if (typeof this.legend !== 'undefined' && this.legend.visible) {
            dataPointEnter.append("text").attr('class', 'dataPoint-name');
            dataPoint.select("text.dataPoint-name").attr("x",
                this.dimension.width
                - this.margin.right
                - this.margin.left + 20
            ).attr("y", function (d, i)
            {
                return i * 20 + 10 - 1;
            }).attr("dy", ".35em").text(function (d)
            {
                return d.name;
            });
            dataPointEnter.append('circle').attr('class', 'dataPoint-dot');
            dataPoint.select('circle.dataPoint-dot').attr('cx',
                this.dimension.width
                - this.margin.right
                - this.margin.left + 10
            ).attr('cy', function (d, i)
            {
                return i * 20 + 10;
            }).attr('r', 4).style('stroke', function (d)
            {
                return self.color(d.name);
            });
            dataPoint.exit().remove();

            let tlength = this.chartSelect.select('.dataPoint-name').node().getComputedTextLength();

            // Adding margin for legend
            if (this.margin.right < tlength) {
                this.margin.right = tlength + 30;
                this.shouldRedraw = true;
            }
        } else if (this.margin.right > 10) {
            this.margin.right = 10;
            this.shouldRedraw = true;
        }
    };

    jsOMS.Chart.ChartAbstract.prototype.drawMarker = function (svg, x, y, dataPointEnter, dataPoint)
    {
        const self = this;
        let temp;

        if (this.dataSettings.marker.visible) {
            temp = dataPointEnter.append('g').attr('class', 'dots').attr('clip-path', 'url(#clipper1)').selectAll('circle').data(function (d)
            {
                return d.points;
            }).enter().append('circle').attr('class', 'dot');
            dataPoint.select('.dots').style('stroke', function (d)
            {
                return self.color(d.name);
            }).selectAll('circle').transition().duration(500).attr('cy', function (d)
            {
                return y(d.y);
            }).attr('cx', function (d)
            {
                return x(d.x);
            }).attr('r', 4);
        }

        if (this.dataSettings.info.visible && this.dataSettings.marker.visible) {
            temp = dataPointEnter.append('g').attr('class', 'dots');

            let div = this.chartSelect.append("div").attr("class", "charttooltip").style("opacity", 0);
            div.html(self.axis.x.label.text + ': ' + 100 + "<br/>" + self.axis.y.label.text + ': ' + 100);

            /* todo: allow also hover on charts without marker... not possible since hover only on marker and not on point? */
            temp.on("mouseover", function (d)
                {
                    let dim = div.node().getBoundingClientRect();
                    let pos = this.getBoundingClientRect();

                    div.transition()
                        .duration(200)
                        .style("opacity", .9);

                    div.html(self.axis.x.label.text + ': ' + d.x + "<br/>" + self.axis.y.label.text + ': ' + d.y)
                    .style("left", (x(d.x) + dim.width / 2) + "px")
                    .style("top", (y(d.y) + dim.height) + "px");
                })
                .on("mouseout", function (d)
                {
                    div.transition()
                        .duration(500)
                        .style("opacity", 0);
                });
        }
    };

    jsOMS.Chart.ChartAbstract.prototype.drawText = function (svg)
    {
        let temp, pos = 0, topmargin = 0;

        /* No subtitle without title */
        if (typeof this.subtitle !== 'undefined' && this.subtitle.text !== '' && this.subtitle.visible && typeof this.title !== 'undefined' && this.title.text !== '' && this.title.visible) {
            pos = this.calculateHorizontalPosition(this.subtitle.position);

            temp = svg.append("text")
                .attr("class", "subtitle")
                .attr('y', this.position.title.top)
                .attr('x', pos)
                .style("text-anchor", this.subtitle.anchor)
                .text(this.subtitle.text);

            topmargin = 10;
            /* only add margin if subtitle exists */

            if (!this.defined.text.subtitle) {
                this.position.subtitle.top = temp.node().getBoundingClientRect().height / 2;
                this.margin.top += temp.node().getBoundingClientRect().height / 2 + topmargin;
                this.defined.text.subtitle = true;
                this.shouldRedraw = true;
            }
        }

        if (typeof this.title !== 'undefined' && this.title.text !== '' && this.title.visible) {
            pos = this.calculateHorizontalPosition(this.title.position);

            temp = svg.append("text")
                .attr("class", "title")
                .attr('y', -this.position.subtitle.top - topmargin)
                .attr('x', pos)
                .style("text-anchor", this.title.anchor)
                .text(this.title.text);

            if (!this.defined.text.title) {
                this.position.title.top = 0;
                this.margin.top += (temp.node().getBoundingClientRect().height) / 2 + this.position.subtitle.top / 2;
                this.defined.text.title = true;
                this.shouldRedraw = true;
            }
        }

        if (typeof this.footer !== 'undefined' && this.footer.text !== '' && this.footer.visible) {
            let spacer = 0;

            // if no x axis available an element less will be drawn and the footer
            // will be out of bounds.
            // todo: fix this hacky solution!!!
            if(typeof this.axis.x === 'undefined') {
                spacer = -this.margin.top;
            }

            pos = this.calculateHorizontalPosition(this.footer.position);

            temp = svg.append("text")
                .attr("class", "footer")
                .attr('y', this.dimension.height
                    - this.margin.bottom + spacer + this.position.footer.top)
                .attr('x', pos)
                .style("text-anchor", this.footer.anchor)
                .text(this.footer.text);

            if (!this.defined.text.footer) {
                this.position.footer.top = temp.node().getBoundingClientRect().height;
                this.margin.bottom += temp.node().getBoundingClientRect().height + 10;
                this.defined.text.footer = true;
                this.shouldRedraw = true;
            }
        }
    };

    jsOMS.Chart.ChartAbstract.prototype.drawAxis = function (svg, xAxis1, yAxis1)
    {
        // draw clipper
        let defs = svg.append('svg').attr('width', 0).attr('height', 0).append('defs'), pos = 0, temp;
        defs.append('clipPath').attr('id', 'clipper1').append('rect').attr('x', 0).attr('y', 0)
            .attr('width',
                this.dimension.width
                - this.margin.right
                - this.margin.left
            )
            .attr('height',
                this.dimension.height
                - this.margin.top
                - this.margin.bottom
            );

        if (typeof this.axis.x !== 'undefined' && this.axis.x.visible) {
            temp = svg.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + (
                        this.dimension.height
                        - this.margin.top
                        - this.margin.bottom
                    ) + ")")
                .call(xAxis1);

            if (this.axis.x.label.visible) {
                pos = this.calculateHorizontalPosition(this.axis.x.label.position);

                temp.append("text")
                    .attr('y', 45)
                    .attr('x', pos)
                    .style("text-anchor", this.axis.x.label.anchor)
                    .text(this.axis.x.label.text);
            }

            if (!this.defined.axis.x) {
                this.margin.bottom += 50;
                this.defined.axis.x = true;
                this.shouldRedraw = true;
            }
        }

        if (typeof this.axis.y !== 'undefined' && this.axis.y.visible) {
            temp = svg.append("g")
                .attr("class", "y axis")
                .attr("transform", "translate(0,0)")
                .call(yAxis1);

            if (this.axis.y.label.visible) {
                pos = this.calculateVerticalPosition(this.axis.y.label.position);

                temp.append("text")
                    .attr("transform", "rotate(-90)")
                    .attr("y", -this.margin.left + 10)
                    .attr('x', pos)
                    .style("text-anchor", this.axis.y.label.anchor)
                    .text(this.axis.y.label.text);
            }

            if (!this.defined.axis.y) {
                this.margin.left += svg.select('.y.axis .tick').node().getBoundingClientRect().width + 25;
                this.defined.axis.y = true;
                this.shouldRedraw = true;
            }
        }

        if (typeof this.axis.x2 !== 'undefined') {

        }

        if (typeof this.axis.y2 !== 'undefined') {

        }
    };

    jsOMS.Chart.ChartAbstract.prototype.drawGrid = function (svg, xGrid, yGrid)
    {
        if (typeof this.grid.x !== 'undefined' && this.grid.x.visible) {
            svg.append("g")
                .attr("class", "x grid")
                .attr("transform", "translate(0," + (this.dimension.height - this.margin.top - this.margin.bottom) + ")")
                .call(xGrid);
        }

        if (typeof this.grid.y !== 'undefined' && this.grid.y.visible) {
            svg.append("g")
                .attr("class", "y grid")
                .call(yGrid);
        }
    };

    jsOMS.Chart.ChartAbstract.prototype.createXScale = function (type)
    {
        if(type === 'ordinal') {
            return d3.scale.ordinal().rangeRoundBands([
                0,
                this.dimension.width
                - this.margin.right
                - this.margin.left
            ], 0.3);
        } else {
            return d3.scale.linear().range([
                0,
                this.dimension.width
                - this.margin.right
                - this.margin.left
            ]);
        }
    };

    jsOMS.Chart.ChartAbstract.prototype.createYScale = function (type)
    {
        if(type === 'ordinal') {
            return d3.scale.ordinal().rangeRoundBands([
                0,
                this.dimension.height
                - this.margin.top
                - this.margin.bottom
            ], 0.3);
        } else {
            return d3.scale.linear().range([
                this.dimension.height
                - this.margin.top
                - this.margin.bottom,
                10
            ]);
        }
    };

    jsOMS.Chart.ChartAbstract.prototype.createXAxis = function (x) {
        const self = this;

        return d3.svg.axis().scale(x).tickFormat(function (d)
        {
            return self.axis.x.tick.prefix + d;
        }).orient("bottom").outerTickSize(self.axis.x.tick.size)
        .innerTickSize(self.axis.x.tick.size).tickPadding(7);
    };

    jsOMS.Chart.ChartAbstract.prototype.createYAxis = function (y) {
        const self = this;

        return d3.svg.axis().scale(y).tickFormat(function (d)
        {
            return self.axis.y.tick.prefix + d;
        }).orient("left").outerTickSize(this.axis.y.tick.size)
        .innerTickSize(this.axis.y.tick.size).tickPadding(7);
    };

    jsOMS.Chart.ChartAbstract.prototype.createXGrid = function (x) {
        return d3.svg.axis()
            .scale(x)
            .orient("bottom")
            //.ticks(0)
            .tickSize(
                -(this.dimension.height
                - this.margin.top - 10
                - this.margin.bottom), 0, 0)
            .tickFormat("");
    };

    jsOMS.Chart.ChartAbstract.prototype.createYGrid = function (y) {
        return d3.svg.axis()
            .scale(y)
            .orient("left")
            //.ticks(0)
            .tickSize(
                -this.dimension.width
                + this.margin.right
                + this.margin.left, 0, 0)
            .tickFormat("");
    };

    jsOMS.Chart.ChartAbstract.prototype.calculateDimension = function ()
    {
        let box = this.chartSelect.node().getBoundingClientRect();

        this.dimension = {
            width: box.width,
            height: box.height
        };
    };

    jsOMS.Chart.ChartAbstract.prototype.clean = function ()
    {
        this.margin = {top: 0, right: 0, bottom: 0, left: 0};
        this.dimension = {width: 0, height: 0};
        this.position = {
            title: {
                top: 0,
                left: 0
            },
            subtitle: {
                top: 0,
                left: 0
            },
            footer: {
                top: 0,
                left: 0
            },
            zoompanel: {
                top: 0,
                left: 0
            }
        };

        this.shouldRedraw = false;
        this.defined = {
            axis: {
                x: false,
                y: false
            },
            text: {
                title: false,
                subtitle: false,
                footer: false
            },
            legend: false
        };

        this.chartSelect.select("*").remove();
    };
}(window.jsOMS = window.jsOMS || {}));
