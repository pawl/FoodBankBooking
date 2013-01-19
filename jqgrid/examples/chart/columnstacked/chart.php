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
->setLegend(array(
	"align"=> 'right',
	"verticalAlign"=> 'top',
	"x"=> -100,
	"y"=> 20,
	"floating"=> true,
	"shadow"=>false,
	"borderWidth"=> 1,
	"backgroundColor"=> '#CCC',
	"backgroundColor" =>'#FFFFFF'

))
->setTooltip(array(
	"formatter"=>"function(){return '<b>'+ this.x +'</b><br/>'+this.series.name +': '+ this.y +'<br/>'+'Total: '+ this.point.stackTotal;}"
))
->setPlotOptions(array(
	"column"=>array("stacking"=>"normal")
))
->addSeries('Jhon', array(5, 3, 4, 7, 2))
->addSeries('Jane', array(2, 2, 3, 2, 1))
->addSeries('Joe', array( 3, 4, 4, 2, 5));

echo $chart->renderChart('', true, 700, 350);

?>
