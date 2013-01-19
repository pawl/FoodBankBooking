<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
//require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");

$loadevent = <<< LOAD
function() {  
	// set up the updating of the chart each second
	var series = this.series[0];
	setInterval(function() {
		var x = (new Date()).getTime(), // current time
		y = Math.random();
		series.addPoint([x, y], true, true);
	}, 1000);
}
LOAD;

$randdata = <<< RNDATA
(function() {
// generate an array of random data
	var data = [],
	time = (new Date()).getTime(),
	i;
	for (i = -19; i <= 0; i++) {
		data.push({
			x: time + i * 1000,
			y: Math.random()
		});
	}
	return data;
})()
RNDATA;

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"spline",
	"marginRight"=>10
))
->setChartEvent('load', $loadevent)
->setTitle(array('text'=>'Live random data'))
->setxAxis(array(
	"type"=>'datetime',
	"tickPixelInterval"=> 150
))
->setyAxis(array(
	"title"=>array("text"=>"Value"),
	"plotLines"=>array(array(
		"value"=>0,
		"width"=>1,
		"color"=>'#808080'
	))
))
->setTooltip(array(
	"formatter"=>"function(){return '<b>'+ this.series.name +'</b><br/>'+Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+Highcharts.numberFormat(this.y, 2);}"
))
->setLegend(array( 
	"enabled"=>false
))
->setExporting('enabled', false)
->addSeries('Random data', 'js:'.$randdata );
echo $chart->renderChart('', true, 700, 350);

?>
