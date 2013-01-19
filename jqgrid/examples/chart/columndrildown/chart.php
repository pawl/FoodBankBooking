<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");


$data = array(
	array(
		"y"=> 55.11,
		"color"=>"js:colors[0]",
		"drilldown"=>array(
			"name"=>'MSIE versions',
			"categories"=>array('MSIE 6.0', 'MSIE 7.0', 'MSIE 8.0', 'MSIE 9.0'),
			"data"=>array(10.85, 7.35, 33.06, 2.81),
			"color"=>"js:colors[0]"
		)
	),
	array(
		"y"=> 21.63,
		"color"=>"js:colors[1]",
		"drilldown"=>array(
			"name"=>'Firefox versions',
			"categories"=>array('Firefox 2.0', 'Firefox 3.0', 'Firefox 3.5', 'Firefox 3.6', 'Firefox 4.0'),
			"data"=>array(0.20, 0.83, 1.58, 13.12, 5.43),
			"color"=>"js:colors[1]"
		)
	),
	array(
		"y"=> 11.94,
		"color"=>"js:colors[2]",
		"drilldown"=>array(
			"name"=>'Chrome versions',
			"categories"=>array('Chrome 5.0', 'Chrome 6.0', 'Chrome 7.0', 'Chrome 8.0', 'Chrome 9.0','Chrome 10.0', 'Chrome 11.0', 'Chrome 12.0'),
			"data"=>array(0.12, 0.19, 0.12, 0.36, 0.32, 9.91, 0.50, 0.22),
			"color"=>"js:colors[2]"
		)
	),
	array(
		"y"=> 7.15,
		"color"=>"js:colors[3]",
		"drilldown"=>array(
			"name"=>'Safari versions',
			"categories"=>array('Safari 5.0', 'Safari 4.0', 'Safari Win 5.0', 'Safari 4.1', 'Safari/Maxthon','Safari 3.1', 'Safari 4.1'),
			"data"=>array(4.55, 1.42, 0.23, 0.21, 0.20, 0.19, 0.14),
			"color"=>"js:colors[3]"
		)
	)	
	
);
$sdata = jqGridUtils::encode($data);
$click = <<<CLICK
function(){
	var drilldown = this.drilldown; 
	if (drilldown) { 
		setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
	} else {
		setChart(name, categories, $sdata);
	}
}
CLICK;

$chart = new jqChart();
$chart->setChartOptions(array(
	"defaultSeriesType"=>"column"
))
->setTitle(array('text'=>'Browser market share, April, 2011'))
->setSubtitle(array("text"=>"Click the columns to view versions. Click again to view brands."))
->setxAxis(array("categories"=>array('MSIE', 'Firefox', 'Chrome', 'Safari', 'Opera')))
->setyAxis(array(
	"title"=>array("text"=>"Total percent market share")
))
->setTooltip(array("formatter"=>"function(){var point = this.point, s = this.x +':<b>'+ this.y +'% market share</b><br/>'; if (point.drilldown) {s += 'Click to view '+ point.category +' versions';} else {s += 'Click to return to browser brands';} return s;}"))
->setPlotOptions(array(
	"column"=> array(
		"cursor"=>'pointer',
		"point"=>array(
			"events"=>array(
				"click"=>"js:".$click
		),
		"dataLabels"=>array(
			"enabled"=>true,
			"color"=>"js:Highcharts.getOptions().colors[0]",
			"style"=>array("fontWeight"=>'bold'),
			"formatter"=>"js:function(){return this.y +'%';}"
		)
	)
)))
->addSeries('Browser brands', $data);
$setser = <<<SETSER
function setChart(name, categories, data, color) {
	chart.xAxis[0].setCategories(categories);
	chart.series[0].remove();
	chart.addSeries({
		name: name,
		data: data,
		color: color || 'white'
     });
}
SETSER;
$chart->setJSCode($setser);
echo $chart->renderChart('', true, 700, 350);

?>
