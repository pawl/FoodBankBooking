<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
//require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");
//$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);

// Tell the db that we use utf-8
//jqGridDB::query($conn,"SET NAMES utf8");

$chart = new jqChart();
$chart->setChartOptions(array("defaultSeriesType"=>"spline"))
->setTitle(array('text'=>'Monthly Average Temperature'))
->setSubtitle(array("text"=>"Source: WorldClimate.com"))
->setxAxis(array(
	"categories"=>array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')
))
->setyAxis(array(
	"title"=>array("text"=>"Temperature"),
	"labels"=>array(
          "formatter"=> "js:function() {
               return this.value + 'C';
            }"
     )
))
->setTooltip(array(
	"crosshairs"=>true,
	"shared"=> true

))
->setPlotOptions(array(
	"spline"=>array("marker"=>array(
		"lineColor"=> "#666666",
		"radius"=> 4,
		"lineWidth"=> 1
	))
))
->addSeries('Tokyo', array(
7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2,array("y"=>26.5, "marker"=>array("symbol"=>'url(sun.png)')),23.3, 18.3, 13.9, 9.6
))
->setSeriesOption('Tokyo',array(
	"marker"=>array("symbol"=>'square')
))
->addSeries('London', array(
array("y"=>3.9, "marker"=>array("symbol"=>'url(snow.png)')),4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8
))
->setSeriesOption('London',array(
	"marker"=>array("symbol"=>'diamond')
));
echo $chart->renderChart('', true, 700, 350);

?>
