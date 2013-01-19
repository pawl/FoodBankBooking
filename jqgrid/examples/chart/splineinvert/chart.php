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
$chart->setChartOptions(array(
	"defaultSeriesType"=>"spline",
	"inverted"=> true,
	"width"=> 500,
	"style"=>array(
            "margin"=>"0 auto"
    )
))
->setTitle(array('text'=>'Atmosphere Temperature by Altitude'))
->setSubtitle(array("text"=>"According to the Standard Atmosphere Model"))
->setxAxis(array(
         "reversed"=> false,
         "title"=>array(
            "enabled"=> true,
            "text"=> 'Altitude'
         ),
         "labels" =>array(
            "formatter"=> "js:function() {
               return this.value +'km';
            }"
         ),
         "maxPadding"=> 0.05,
         "showLastLabel"=> true

))
->setyAxis(array(
	"title"=>array("text"=>"Temperature C"),
	"labels"=>array(
          "formatter"=> "js:function() {
               return this.value + 'C';
            }"
     ),
     "lineWidth"=> 2
))
->setTooltip(array("formatter"=>"function(){return ''+  this.x +' km: '+ this.y +'C';}"))
->setPlotOptions(array(
	"spline"=>array("marker"=>array("enabled"=>true))
))
->addSeries('Temperature', array(
array(0, 15), array(10, -50), array(20, -56.5), array(30, -46.5), array(40, -22.1), array(50, -2.5), array(60, -27.7), array(70, -55.7), array(80, -76.5)
));
echo $chart->renderChart('', true, 700, 350);

?>
