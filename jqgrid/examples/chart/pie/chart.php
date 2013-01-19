<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");


$chart = new jqChart();
$chart->setTitle(array('text'=>'Browser market shares at a specific website, 2010'))
->setTooltip(array("formatter"=>"function(){return '<b>'+ this.point.name +'</b>: '+ this.y +' %';}"))
->setPlotOptions(array(
	"pie"=> array(
		"allowPointSelect"=> true,
		"cursor"=> 'pointer',
		"dataLabels"=>array(
			"enabled"=>true,
			"color"=>'#000000',
			"connectorColor"=>'#000000',
			"formatter"=>"js:function(){return '<b>'+ this.point.name +'</b>: '+ this.y +' %'}"
		)
	)
))
->addSeries('Browser share', array(
	array('Firefox',   45.0),
	array('IE',       26.8),
	array(
               "name"=> 'Chrome',    
               "y"=> 12.8,
               "sliced"=> true,
               "selected"=> true
            ),
	array('Safari',    8.5),
	array('Opera',     6.2),
	array('Others',   0.7)
))
->setSeriesOption('Browser share', 'type','pie');
echo $chart->renderChart('', true, 700, 350);

?>
