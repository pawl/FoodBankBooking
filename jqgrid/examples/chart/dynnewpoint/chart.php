<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
//require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");

$clickevent = <<< LOAD
function(e) {
	// find the clicked values and the series
	var x = e.xAxis[0].value,
	y = e.yAxis[0].value,
	series = this.series[0];

	// Add it
	series.addPoint([x, y]);
}
LOAD;

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"scatter",
	"margin"=>array(70, 50, 60, 80)
))
->setChartEvent('click', $clickevent)
->setTitle(array('text'=>'User supplied data'))
->setSubtitle(array('text'=>'Click the plot area to add a point. Click a point to remove it.'))
->setxAxis(array(
	"minPadding"=>0.2,
	"maxPadding"=>0.2,
	"maxZoom"=>60
))
->setyAxis(array(
	"title"=>array("text"=>"Value"),
	"minPadding"=>0.2,
	"maxPadding"=>0.2,
	"maxZoom"=>60,
	"plotLines"=>array(array(
		"value"=>0,
		"width"=>1,
		"color"=>'#808080'
	))
))
->setPlotOptions(array(
	"series"=>array(
		"lineWidth"=>1,
		"point"=>array(
			"events"=>array(
				"click"=>"js:function(){if (this.series.data.length > 1) this.remove();}"
			)
		)
	)
))
->setLegend(array( 
	"enabled"=>false
))
->setExporting('enabled', false)
->addSeries('data', array(
arraY(20, 20), array(80, 80)
));
echo $chart->renderChart('', true, 700, 350);

?>
