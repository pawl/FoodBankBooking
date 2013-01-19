<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
//require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");


$chart = new jqChart();
$chart->setChartOptions(array("zoomType"=>"xy"))
->setTitle(array('text'=>'Average Monthly Temperature and Rainfall in Tokyo'))
->setSubtitle(array('text'=>'Source: WorldClimate.com'))
->setxAxis(array(
	"categories"=>array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')
))
->setyAxis(array(
	array( 
		"labels"=>array(
			"formatter"=>"js:function(){return this.value +'C';}",
			"style"=>array("color"=>'#89A54E')
		),
		"title"=>array(
			'text'=> 'Temperature',
			"style"=>array("color"=>'#89A54E')
		)
	),
	array( 
		"title"=>array(
			'text'=> 'Rainfall',
			"style"=>array("color"=>'#4572A7')
		),
		"labels"=>array(
			"formatter"=>"js:function(){return this.value +'mm';}",
			"style"=>array("color"=>'#4572A7')
		),
		"opposite"=> true
	)
))
->setTooltip(array("formatter"=>"function(){return this.x +': '+ this.y + (this.series.name == 'Rainfall' ? ' mm' : 'C')}"))
->setLegend(array(
	"layout"=> 'vertical',
	"align"=> 'left',
	"x"=> 120,
	"y"=> 100,
	"verticalAlign"=> 'top',
	"floating"=> true,
	"backgroundColor"=> '#FFFFFF'
))
->addSeries('Rainfall', array(49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4))
->setSeriesOption('Rainfall',array('type'=>'column', "color"=>'#4572A7',"yAxis"=>1))
->addSeries('Temperature', array(7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6))
->setSeriesOption('Temperature',array('type'=>'spline', "color"=>'#89A54E'));
echo $chart->renderChart('', true, 700, 350);

?>
