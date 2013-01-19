<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";

require_once ABSPATH."php/jqChart.php";

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"bar"
))
->setTitle(array('text'=>'Historic World Population by Region'))
->setSubtitle(array("text"=>'Source: Wikipedia.org'))
->setxAxis(array(
	"categories" => array('Africa', 'America', 'Asia', 'Europe', 'Oceania'),
	"title"=>array("text"=>null),
))
->setyAxis(array(
	"min"=>0,
	"title"=>array("text"=>'Population (millions)'),
	"align"=> 'high'
))
->setTooltip(array(
	"formatter"=>"function(){return this.series.name +': '+ this.y +' millions';}"
))
->setPlotOptions(array(
	"bar"=>array(
		"dataLabels"=>array(
			"states"=>array("enabled"=>true)
		)
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
	"backgroundColor"=> '#FFFFFF',
	"shadow"=>true
))
->addSeries('Year 1800', array(107, 31, 635, 203, 2))
->addSeries('Year 1900', array(133, 156, 947, 408, 6))
->addSeries('Year 2008', array(973, 914, 4054, 732, 34));

echo $chart->renderChart('', true, 700, 350);

?>
