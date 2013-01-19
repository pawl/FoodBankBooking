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
$chart->setChartOptions(array("defaultSeriesType"=>"line","marginRight"=>130,"marginBottom"=>25))
->setTitle(array('text'=>'Monthly Average Temperature',"x"=>-20))
->setSubtitle(array("text"=>"Source: WorldClimate.com","x"=>-20))
->setxAxis(array("categories"=>array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')))
->setyAxis(array("title"=>array("text"=>"Temperature (°C)")))
->setTooltip(array("formatter"=>"function(){return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +' (°C)';}"))
->setLegend(array( "layout"=>"vertical","align"=>"right","verticalAlign"=>'top',"x"=>-10,"y"=>100,"borderWidth"=>0))
->addSeries('Tokyo', array(7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6))
->addSeries('New York', array(-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5))
->addSeries('Berlin', array(-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0))
->addSeries('London', array(3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8));
echo $chart->renderChart('',true,700, 350);

?>
