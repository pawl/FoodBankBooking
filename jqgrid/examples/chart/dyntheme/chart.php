<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqUtils.php";
//require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");
//$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);


// get the theme
$theme = 'dark-blue';
//isset ($_GET['theme']) ? $_GET['theme'] : "";

$dateformat = 'l, M j, Y';
//Let get first the data from csv
$newisits = array();
$allvisits = array();
$handle = fopen("analytics.csv", "r");
if($handle) {
	while (($data = fgetcsv($handle, 3200, ",")) !== FALSE) {
		//$date = DateTime::createFromFormat($dateformat, $data[0]);
		$d = strtotime($data[0])*1000;
		$allvisits[] = array($d, (int)str_replace(",","",$data[1]));
		$newisits[] = array($d, (int)str_replace(",","",$data[2]));
	}
}
fclose($handle);

// create the chart instance
$chart = new jqChart();
$chart->setChartOptions(array("defaultSeriesType"=>"line"))
->setTitle(array('text'=>'Daily visits at www.example.com'))
->setSubtitle(array("text"=>"Source: Google Analytics"))
// set xAxis to be datetime
->setxAxis(array(
	"type"=>"datetime",
	"tickInterval"=> 7 * 24 * 3600 * 1000,
	"tickWidth"=> 0,
	"gridLineWidth"=>1,
    "labels"=>array(
            "align"=> 'left',
            "x"=> 3,
            "y"=>-3 
     )
))
// lef and right Y axis
->setyAxis(array(
	// left y axis
	array(
		"title"=>array("text"=>null),
		"labels"=>array(
			"align"=>"left",
			"x"=>3,
			"y"=>16,
			"formatter"=>"js:function(){return Highcharts.numberFormat(this.value, 0);}"
		),
		"showFirstLabel"=>false
	),
	// right y axis
	array(
		"linkedTo"=>0,
		"gridLineWidth"=>0,
		"opposite"=>true,
		"title"=>array("text"=>null),
		"labels"=>array(
			"align"=>"right",
			"x"=>-3,
			"y"=>16,
			"formatter"=>"js:function(){return Highcharts.numberFormat(this.value, 0);}"
		),
		"showFirstLabel"=>false
	),

))
->setTooltip(array(
	"shared"=>true,
	"crosshairs"=>true
))
->setLegend(array( 
	"align"=>"left",
	"verticalAlign"=>'top',
	"y"=>50,
	"borderWidth"=>0,
	"floating"=>true
))
// Here wi attach a click function when cklic on series point
->setPlotOptions(array(
	"series"=>array(
		"cursor"=>"pointer",
		"point"=>array(
			"events"=>array(
				"click"=>"js:function(event){
					// this refers to entry object again with data
					jQuery.jgrid.info_dialog(this.series.name, Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+ this.y +' visits', 'Close',{buttonalign:'right',top:this.pageY, left:this.pageX, modal:false, overlay:0});
					
				}"
			)
		),
		"marker"=>array("lineWidth"=>1)
	)
))
// fil the data
->addSeries('All Visits',$allvisits)
->setSeriesOption('All Visits', array(
	"lineWidth"=>4,
	"marker"=>array(
		"radius"=>4
	)
))
->setTheme($theme)
->addSeries('New Visitors', $newisits);

echo $chart->renderChart('',true, 700, 350);

?>
