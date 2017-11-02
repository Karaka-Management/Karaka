/**
 * Spreadsheet view.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    /** @namespace jsOMS.Spreadsheet */
    jsOMS.Autoloader.defineNamespace('jsOMS.Spreadsheet');

    jsOMS.Spreadsheet.Spreadsheet = function(id, dataset, options) 
    {
    	this.spreadsheet = document.getElementById(id);
    	this.title = '';
    	this.sheets = [];
    	this.columns = true;
    	this.rows = true;
    	this.dataset = [];
    	this.compiledData = [];
    	this.scroll = {h: false, v: false};
    };

    jsOMS.SpreadSheet.prototype.draw = function() 
    {
    	let col = 0,
    		row = 0,
    		cRows = this.dataset.length(),
    		cCols = 0;
    		j = 0,
    		this.compiledData = this.dataset;

    	for(let i = 0; i < cRows; i++) {
    		cCols = this.compiledData[i].length();

    		for(j = 0; j < cCols; j++) {
    			this.compiledData[i][j] = Functions.evaluate(this.compiledData[i][j], compiledData);

    			this.drawCell(this.compiledData[i][j]);
    		}
    	}
    };

    jsOMS.SpreadSheet.prototype.drawCell = function() 
    {
    };
}(window.jsOMS = window.jsOMS || {}));