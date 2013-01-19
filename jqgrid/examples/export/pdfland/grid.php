<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
require_once(ABSPATH.'/php/tcpdf/config/lang/eng.php');
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);

// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT OrderID, OrderDate, CustomerID, ShipName, Freight FROM orders';
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"OrderID",
	"caption"=>"PDF export Landscape"
));
// Change some property of the field(s)
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y"),
    "search"=>false
    )
);
$grid->setColProperty("ShipName", array("width"=>"250"));
$grid->setColProperty("Freight", array("label"=>"Test", "align"=>"right"));
// Enable navigator
$grid->navigator = true;
// Enable pdf export on navigator
$grid->setNavOptions('navigator', array("pdf"=>true, "add"=>false,"edit"=>false,"del"=>false,"view"=>false, "excel"=>false));

$oper = jqGridUtils::GetParam("oper");
// prevent some executions when not excel export
if($oper == "pdf") {
	$grid->setPdfOptions(array(
		// set the page orientation to landscape
		"page_orientation"=>"L",
		// enable header information
		"header"=>true,
		// set bigger top margin
		"margin_top"=>27,
		// set logo image
		"header_logo"=>"logo.gif",
		// set logo image width
		"header_logo_width"=>30,
		//header title
		"header_title"=>"jqGrid pdf table",
		// and a header string to print
		"header_string"=>"by Trirand Inc - www.trirand.net"
		));
}
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
