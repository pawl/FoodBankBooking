/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function(){
	var chart = new Highcharts.Chart({
		"credits":{"enabled":false},
		"chart":{"renderTo":"jqchart","defaultSeriesType":"column"},
		"series":[
			{"name":"Browser brands","data":[
				{
					"y":55.11,
					"color":Highcharts.getOptions().colors[0],
					"drilldown":
						{"name":"MSIE versions",
						"categories":["MSIE 6.0","MSIE 7.0","MSIE 8.0","MSIE 9.0"],
						"data":[10.85,7.35,33.06,2.81],
						"color":Highcharts.getOptions().colors[0]}},
				{
					"y":21.63,
					"color":Highcharts.getOptions().colors[1],
					"drilldown":
						{"name":"Firefox versions",
						"categories":["Firefox 2.0","Firefox 3.0","Firefox 3.5","Firefox 3.6","Firefox 4.0"],
						"data":[0.2,0.83,1.58,13.12,5.43],
						"color":Highcharts.getOptions().colors[1]}
				},{
					"y":11.94,
					"color":Highcharts.getOptions().colors[2],
					"drilldown":
						{"name":"Chrome versions",
						"categories":["Chrome 5.0","Chrome 6.0","Chrome 7.0","Chrome 8.0","Chrome 9.0","Chrome 10.0","Chrome 11.0","Chrome 12.0"],
						"data":[0.12,0.19,0.12,0.36,0.32,9.91,0.5,0.22],
						"color":Highcharts.getOptions().colors[2]}
				},{
					"y":7.15,
					"color":Highcharts.getOptions().colors[3],
					"drilldown":{
						"name":"Safari versions",
						"categories":["Safari 5.0","Safari 4.0","Safari Win 5.0","Safari 4.1","Safari/Maxthon","Safari 3.1","Safari 4.1"],
						"data":[4.55,1.42,0.23,0.21,0.2,0.19,0.14],
						"color":Highcharts.getOptions().colors[3]
					}
				}
			]
		}],
	"title":{
		"text":"Browser market share, April, 2011"
	},
	"subtitle":{
		"text":"Click the columns to view versions. Click again to view brands."
	},
	"xAxis":{
		"categories":["MSIE","Firefox","Chrome","Safari","Opera"]
	},
	"yAxis":{
		"title":{
			"text":"Total percent market share"
		}
	},
	"tooltip":{
		"formatter":function(){var point = this.point, s = this.x +':<b>'+ this.y +'% market share</b><br/>'; if (point.drilldown) {s += 'Click to view '+ point.category +' versions';} else {s += 'Click to return to browser brands';} return s;}
	},
	"plotOptions":{
		"column":{
			"cursor":"pointer",
			"point":{
				"events":{
					"click":function(){ 
						var drilldown = this.drilldown; 
						if (drilldown) { 
							setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
						} else {
							setChart(name, categories, data);
						} 
					}
				}
			},
			"dataLabels":{
				"enabled":true,
				"color":Highcharts.getOptions().colors[0],
				"style":{
					"fontWeight":"bold"
				},
				"formatter":function(){return this.y +'%';}}}},
	"exporting":{"url":"\thttp://trirand.com/jqcharts/"}});});


