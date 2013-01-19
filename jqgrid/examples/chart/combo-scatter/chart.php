<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");


$chart = new jqChart();
$chart->setTitle(array('text'=>'Scatter plot with regression line'))
->setxAxis(array(
	"min"=>-0.5,
	"max"=>5.5
))
->setyAxis(array(
	"min"=>0
))
->addSeries('Regression Line', array(array(0,1.11),array(5, 4.51)))
->setSeriesOption('Regression Line',array(
	'type'=>'line',
	'marker'=>array("enabled"=>false),
	'states'=>array("hover"=>array("lineWidth"=>1)),
	'enableMouseTracking'=>false
))
->addSeries('Observations', array(1, 1.5, 2.8, 3.5, 3.9, 4.2))
->setSeriesOption('Observations',array(
	'type'=>'scatter',
	'marker'=>array("radius"=>4)
));

echo $chart->renderChart('', true, 700, 350);

?>
