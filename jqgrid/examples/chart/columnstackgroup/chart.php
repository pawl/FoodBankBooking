<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";

require_once ABSPATH."php/jqChart.php";

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"column"
))
->setTitle(array('text'=>'Total fruit consumtion, grouped by gender'))
->setxAxis(array(
	"categories"=>array('Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas')
))
->setyAxis(array(
	"min"=>0,
	"allowDecimals"=> false,
	"title"=>array("text"=>"Number of fruits")
))
->setTooltip(array(
	"formatter"=>"function(){return '<b>'+ this.x +'</b><br/>'+this.series.name +': '+ this.y +'<br/>'+'Total: '+ this.point.stackTotal;}"
))
->setPlotOptions(array(
	"column"=>array("stacking"=>"normal")
))
->addSeries('Jhon', array(5, 3, 4, 7, 2))
->setSeriesOption('Jhon', 'stack', 'male')
->addSeries('Joe', array( 3, 4, 4, 2, 5))
->setSeriesOption('Joe', 'stack', 'male')
->addSeries('Jane', array(2, 2, 3, 2, 1))
->setSeriesOption('Jane', 'stack', 'female')
->addSeries('Janet', array(3, 0, 4, 4, 3))
->setSeriesOption('Janet', 'stack', 'female');

echo $chart->renderChart('', true, 700, 350);

?>
