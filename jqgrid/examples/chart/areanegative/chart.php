<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";

require_once ABSPATH."php/jqChart.php";

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"area"
))
->setTitle(array('text'=>'Area chart with negative values'))
->setxAxis(array(
	"categories"=>array('Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas')
))
->setTooltip(array(
	"formatter"=>"function(){return this.series.name +': '+ this.y +'';}"
))
->addSeries('Jhon', array(5, 3, 4, 7, 2))
->addSeries('Jane', array(2, -2, -3, 2, 1))
->addSeries('Joe', array( 3, 4, 4, -2, 5));

echo $chart->renderChart('', true, 700, 350);

?>
