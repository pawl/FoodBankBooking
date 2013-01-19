<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");


$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"column"
))
->setTitle(array('text'=>'Monthly Average Rainfall'))
->setSubtitle(array("text"=>"Source: WorldClimate.com"))
->setxAxis(array("categories"=>array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')))
->setyAxis(array(
	"min"=>0,
	"title"=>array("text"=>"Rainfall (mm)")
))
->setLegend(array( 
	"layout"=>"vertical",
	"backgroundColor"=>'#FFFFFF',
	"align"=>"left",
	"verticalAlign"=>'top',
	"x"=>100,
	"y"=>70,
	"floating"=>true,
	"shadow"=>true
))
->setTooltip(array("formatter"=>"function(){return this.x +': '+ this.y +' mm';}"))
->setPlotOptions(array(
	"column"=> array(
		"pointPadding"=> 0.2,
		"borderWidth"=> 0
	)
))
->addSeries('Tokyo', array(49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4))
->addSeries('New York', array(83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3))
->addSeries('London', array(83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3))
->addSeries('Berlin', array(42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1));
echo $chart->renderChart('', true, 700, 350);

?>
