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
$grid->SelectCommand = 'SELECT OrderID, OrderDate, CustomerID, EmployeeID, Freight, ShipName FROM orders';
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model from SQL query
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set alternate background using altRows property
$grid->setGridOptions(array(
    "rowNum"=>10,
    "sortname"=>"OrderID",
    "rowList"=>array(10,20,50),
    "height"=>'auto',
    "footerrow"=>true,
    "userDataOnFooter"=>true,
    "grouping"=>true,
    "groupingView"=>array(
    	"groupField" => array('CustomerID', 'EmployeeID'),
    	"groupColumnShow" => array(true, true),
    	"groupText" =>array('<b> Client:{0}</b> Sum Freight: {Freight}', '<b>Employee: {0}</b> Sum Freight: {Freight}'),
    	"groupSummary" => array(false, false)
    ) 
    ));
// Change some property of the field(s)
$grid->setColProperty("OrderID", array("label"=>"ID", "width"=>60));
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
    )
);
// Add a summary property to the Freight Column
$grid->setColProperty("Freight", array("summaryType"=>"sum", "summaryTpl"=>"{0}", "formatter"=>"number"));
$summaryrows = array("Freight"=>array("Freight"=>"SUM"));
// Enjoy
$grid->renderGrid('#grid','#pager',true, $summaryrows, null, true,true);
$conn = null;
?>
