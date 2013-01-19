<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";

require_once ABSPATH."php/jqChart.php";

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"column"
))
->setTitle(array('text'=>'Stacked column chart'))
->setxAxis(array(
	"categories"=>array('Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas')
))
->setyAxis(array(
	"min"=>0,
	"title"=>array("text"=>"Total fruit consumption")
))
->setTooltip(array(
	"formatter"=>"function(){return this.series.name +': '+ this.y +' ('+ Math.round(this.percentage) +'%)';}"
))
->setPlotOptions(array(
	"column"=>array("stacking"=>"percent")
))
->addSeries('Jhon', array(5, 3, 4, 7, 2))
->addSeries('Jane', array(2, 2, 3, 2, 1))
->addSeries('Joe', array( 3, 4, 4, 2, 5));

echo $chart->renderChart('', true, 700, 350);

?>
