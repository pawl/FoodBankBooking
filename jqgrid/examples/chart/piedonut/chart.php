<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");


$chart = new jqChart();
$chart->setChartOptions(array(
	"margin"=>array(50, 0, 0, 0),
	"plotBackgroundColor"=> 'none',
	"plotBorderWidth"=> 0,
	"plotShadow"=> false	
))
->setTitle(array('text'=>'Browser market shares at a specific website'))
->setSubtitle(array('text'=>'Inner circle: 2008, outer circle: 2010'))
->setTooltip(array("formatter"=>"function(){return '<b>'+ this.point.name +'</b>: '+ this.y +' %';}"))
->addSeries('2008', array(
	array("name"=> 'Firefox', "y"=>  44.2, "color"=>'#4572A7'),
	array("name"=>'IE', "y"=>46.6, "color"=>'#AA4643'),
	array("name"=> 'Chrome', "y"=> 3.1, "color"=>'#89A54E'),
	array("name"=>'Safari', "y"=> 2.7, "color"=>'#80699B'),
	array("name"=>'Opera', "y"=> 2.3, "color"=>'#3D96AE'),
	array("name"=>'Mozilla',"y"=>   0.4, "color"=>'#DB843D')
))
->setSeriesOption('2008', array(
	'type'=>'pie',
	'size'=>'45%',
	'innerSize'=> '20%',
	'dataLabels'=>array("enabled"=>false)
	)
)
->addSeries('2010', array(
	array("name"=> 'Firefox', "y"=>  45.0, "color"=>'#4572A7'),
	array("name"=>'IE', "y"=>26.8, "color"=>'#AA4643'),
	array("name"=> 'Chrome', "y"=> 12.8, "color"=>'#89A54E'),
	array("name"=>'Safari', "y"=> 8.5, "color"=>'#80699B'),
	array("name"=>'Opera', "y"=> 6.2, "color"=>'#3D96AE'),
	array("name"=>'Mozilla',"y"=> 0.2, "color"=>'#DB843D')
))
->setSeriesOption('2010', array(
	'type'=>'pie',
	'innerSize'=> '45%',
	'dataLabels'=>array("enabled"=>true)
	)
);
echo $chart->renderChart('', true, 700, 350);

?>
