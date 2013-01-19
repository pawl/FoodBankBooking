<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";

require_once ABSPATH."php/jqChart.php";

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"areaspline"
))
->setTitle(array('text'=>'Average fruit consumption during one week'))
->setLegend(array(
	"layout"=> 'vertical',
	"align"=> 'right',
	"verticalAlign"=> 'top',
	"x"=> 150,
	"y"=> 100,
	"floating"=> true,
	"borderWidth"=> 1,
	"backgroundColor"=> '#FFFFFF'
))
->setxAxis(array(
	"categories"=> array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
	"plotBands"=>array(
		array( // mark weekend
			"from"=>4.5,
			"to"=>6.5,
			"color"=>'rgba(68, 170, 213, .2)'
		)
	)
))
->setyAxis(array(
	"title"=>array("text"=> 'Fruit units')
))
->setTooltip(array(
	"formatter"=>"function(){return this.x +': '+ this.y+' units';}"
))
->setPlotOptions(array(
	"areaspline"=>array(
		"fillOpacity"=> 0.5
	)
))
->addSeries('Jhon', array(3, 4, 3, 5, 4, 10, 12))
->addSeries('Jane', array(1, 3, 4, 3, 3, 5, 4));

echo $chart->renderChart('', true, 700, 350);

?>
