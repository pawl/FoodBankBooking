<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";

require_once ABSPATH."php/jqChart.php";

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"area",
	 "spacingBottom"=>30
))
->setTitle(array('text'=>'Fruit consumption *'))
->setSubtitle(array(
	"text"=>'* Jane\'s banana consumption is unknown',
	"floating"=> true,
	"align"=>"right",
	"verticalAlign"=> 'bottom',
	"y"=>15
))
->setLegend(array(
	"layout"=> 'vertical',
	"align"=> 'left',
	"verticalAlign"=> 'top',
	"x"=> 150,
	"y"=> 100,
	"floating"=> true,
	"borderWidth"=> 1,
	"backgroundColor"=> '#FFFFFF'

))
->setxAxis(array(
	"categories"=> array('Apples', 'Pears', 'Oranges', 'Bananas', 'Grapes', 'Plums', 'Strawberries', 'Raspberries')
))
->setyAxis(array(
	"title"=>array("text"=> 'Y-Axis'),
	"labels"=>array("formatter"=>"js:function(){return this.value;}")
))
->setTooltip(array(
	"formatter"=>"function(){return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y;}"
))
->setPlotOptions(array(
	"area"=>array(
		"fillOpacity"=> 0.5
	)
))
->addSeries('Jhon', array(0, 1, 4, 4, 5, 2, 3, 7))
->addSeries('Jane', array(1, 0, 3, null, 3, 1, 2, 1));

echo $chart->renderChart('', true, 700, 350);

?>
