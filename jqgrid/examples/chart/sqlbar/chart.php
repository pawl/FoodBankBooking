<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);

// Tell the db that we use utf-8
jqGridDB::query($conn,"SET NAMES utf8");

$chart = new jqChart( $conn );
$chart->setChartOptions(array("defaultSeriesType"=>"bar"))
->setTitle(array('text'=>'Freight  1997',"x"=>-20))
->setyAxis(array("title"=>array("text"=>"Freight")))
->setTooltip(array("formatter"=>"function(){return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y;}"))
->addSeries('Blauer See Delikatessen', "SELECT SUM(Freight) FROM orders WHERE CustomerID =?  AND OrderDate BETWEEN '1997-01-01' AND '1997-12-31' ",array('BERGS'))
->addSeries('White Clover Markets', "SELECT SUM(Freight) FROM orders WHERE CustomerID =?  AND OrderDate BETWEEN '1997-01-01' AND '1997-12-31'",array('WHITC'));
echo $chart->renderChart('',true,700, 350);

?>
