<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";

require_once ABSPATH."php/jqChart.php";

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"area",
	"inverted"=>true
))
->setTitle(array('text'=>'Average fruit consumption during one week'))
->setSubtitle(array(
	"style"=>array(
		"position"=> 'absolute',
		"right"=> '0px',
		"bottom"=> '10px'
	)
))
->setLegend(array(
	"layout"=> 'vertical',
	"align"=> 'right',
	"verticalAlign"=> 'top',
	"x"=> -100,
	"y"=> 100,
	"floating"=> true,
	"borderWidth"=> 1,
	"backgroundColor"=> '#FFFFFF'

))
->setxAxis(array(
	"categories"=> array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
))
->setyAxis(array(
	"title"=>array("text"=> 'Number of units'),
	"labels"=>array("formatter"=>"js:function(){return this.value;}")
))
->setTooltip(array(
	"formatter"=>"function(){return this.x +': '+ this.y;}"
))
->setPlotOptions(array(
	"area"=>array(
		"fillOpacity"=> 0.5
	)
))
->addSeries('Jhon', array(3, 4, 3, 5, 4, 10, 12))
->addSeries('Jane', array(1, 3, 4, 3, 3, 5, 4));

echo $chart->renderChart('', true, 680, 350);

?>
