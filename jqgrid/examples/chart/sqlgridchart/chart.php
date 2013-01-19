<?php
require_once '../../../jq-config.php';
//require_once ABSPATH."php/jqUtils.php";
require_once ABSPATH."php/jqGrid.php";
//require_once ABSPATH."php/jqGridArray.php";
//require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqChart.php";
ini_set("display_errors","1");

// get your data manually and build the array
$myconn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
$myconn->query("SET NAMES utf8");
$sth = $myconn->prepare("SELECT CustomerID, SUM(Freight) AS Freight FROM orders WHERE  (CustomerID ='BERGS' OR  CustomerID ='WHITC' ) AND OrderDate BETWEEN '1997-01-01' AND '1997-12-31' GROUP BY CustomerID");
$sth->execute();
$customers = $sth->fetchAll(PDO::FETCH_ASSOC);

$chart = new jqChart( );
$chart->setChartOptions(array("defaultSeriesType"=>"bar"))
->setTitle(array('text'=>'Freight  1997'))
->setyAxis(array("title"=>array("text"=>"Freight")))
->setJSCode("mychart = chart;")
->setTooltip(array("formatter"=>"function(){return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y;}"))
// set the series from the array
->addSeries($customers[0]['CustomerID'], array($customers[0]['Freight'] ))
->addSeries($customers[1]['CustomerID'], array($customers[1]['Freight'] ));
echo $chart->renderChart('',true,700, 350);

// building the grid
$grid = new jqGridRender(null);
$grid->setColModel(array(array("name"=>"CustomerID", "key"=>true), array("name"=>"Freight")));
$grid->setUrl('grid.php');
$grid->setGridOptions(array(
	// this is needed to tell the grid that the data is local
	"datatype"=>"local",
	// and here is the local data
    "data"=>$customers
));
$grid->navigator = false;
$grid->renderGrid('#grid','#pager',true, null, null, false,false);

// Enjoy
?>
