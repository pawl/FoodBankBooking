<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
//require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");

$tooltip = <<<TOOL
function()
{
	var s;
	if (this.point.name) { // the pie chart
		s = ''+ this.point.name +': '+ this.y +' fruits';
	} else {
		s = ''+ this.x  +': '+ this.y;
	}
	return s;
}
TOOL;

$chart = new jqChart();
$chart->setTitle(array('text'=>'Combination chart'))
->setxAxis(array(
	"categories"=>array('Apples', 'Oranges', 'Pears', 'Bananas', 'Plums')
))
->setTooltip(array("formatter"=>$tooltip))
->setLabels(array(
	"items"=>array(array(
		"html"=> 'Total fruit consumption',
		"style"=>array("left"=>"40px","top"=>"8px","color"=>"black")
	))
))
->addSeries('Jane', array(3, 2, 1, 3, 4))
->setSeriesOption('Jane','type','column')
->addSeries('John', array(2, 3, 5, 7, 6))
->setSeriesOption('John','type','column')
->addSeries('Joe', array(4, 3, 3, 9, 0))
->setSeriesOption('Joe','type','column')
->addSeries('Total consumption', array(
	array("name"=>"Jane", "y"=>13,'color'=>'#4572A7'),
	array("name"=>"John", "y"=>23,'color'=>'#AA4643'),
	array("name"=>"Joe", "y"=>19,'color'=>'#89A54E')
))
->setSeriesOption('Total consumption',array(
	"type"=>"pie",
	"center"=>array(100, 80),
	"size"=>100,
	"showInLegend" =>false,
	"dataLabels"=>array("enabled"=>false)
))
->addSeries('Average', array(3, 2.67, 3, 6.33, 3.33))
->setSeriesOption('Average', 'type', 'spline');
echo $chart->renderChart('', true, 700, 350);

?>
