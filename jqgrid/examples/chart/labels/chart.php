<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
require_once ABSPATH."php/jqChart.php";

$chart = new jqChart();
$chart->setChartOptions(array("defaultSeriesType"=>"line"))
->setTitle(array('text'=>'Monthly Average Temperature'))
->setSubtitle(array("text"=>"Source: WorldClimate.com"))
->setxAxis(array("categories"=>array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')))
->setyAxis(array("title"=>array("text"=>"Temperature (°C)")))
->setPlotOptions(array("line"=>array("dataLabels"=>array("enabled"=>true),"enableMouseTracking"=> false)))
->addSeries('Tokyo', array(7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6))
->addSeries('London', array(3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8));
echo $chart->renderChart('', true, 700, 350'',true,'1000');

?>
