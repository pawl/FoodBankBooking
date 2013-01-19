<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";

require_once ABSPATH."php/jqChart.php";

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"area"
))
->setTitle(array('text'=>'Historic and Estimated Worldwide Population Growth by Region'))
->setSubtitle(array("text"=>'Source: Wikipedia.org'))
->setxAxis(array(
	"categories"=> array('1750', '1800', '1850', '1900', '1950', '1999', '2050'),
	"tickmarkPlacement"=> 'on',
	"title"=>array("enabled"=>false)
))
->setyAxis(array(
	"title"=>array("text"=> 'Billions'),
	"labels"=>array("formatter"=>"js:function(){return this.value / 1000;}")
))
->setTooltip(array(
	"formatter"=>"function(){return this.x +': '+ Highcharts.numberFormat(this.y, 0, ',') +' millions';}"
))
->setPlotOptions(array(
	"area"=>array(
		"stacking"=> 'normal',
		"lineColor"=> '#666666',
		"lineWidth"=> 1,
		"marker"=>array(
			"lineWidth"=> 1,
			"lineColor"=>"#666666"
		)
	)
))
->addSeries('Asia', array(502, 635, 809, 947, 1402, 3634, 5268))
->addSeries('Africa', array(106, 107, 111, 133, 221, 767, 1766))
->addSeries('Europe', array(163, 203, 276, 408, 547, 729, 628))
->addSeries('America', array(18, 31, 54, 156, 339, 818, 1201))
->addSeries('Oceania', array(2, 2, 2, 6, 13, 30, 46));

echo $chart->renderChart('', true, 700, 350);

?>
