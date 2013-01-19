<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT CustomerID, ShipName, OrderID, OrderDate, Freight, ShipAddress, ShipCity FROM orders';
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
$grid->setPrimaryKeyId('OrderID');
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"OrderID",
	"shrinkToFit"=>false,
	"width"=>600,
	"rownumbers"=>true
));
// set frozen property
$grid->setColProperty("CustomerID", array(
    "frozen"=>true,
	"width"=>100
    )
);
$grid->setColProperty("ShipName", array(
	"width"=>150,
	"frozen"=>true
	)
);
// Change some property of the field(s)
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y"),
    "search"=>false
    )
);
// Enable navigator
$grid->navigator = true;
// Enable excel export
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>false));

// 
// Call the frozen cols method
$grid->callGridMethod('#grid', 'setFrozenColumns');
// Enjoy

$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$conn = null;
?>
