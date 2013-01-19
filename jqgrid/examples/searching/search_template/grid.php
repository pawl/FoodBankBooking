<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqCalendar.php";

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
    "sortname"=>"OrderID"
));
// Change some property of the field(s)
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
    )
);
$grid->setColProperty("ShipName", array("width"=>"200"));
// Enable navigator
$grid->navigator = true;
// Enable search
// By default we have multiple search enabled
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>false));

$template1 = 
'{ "groupOp": "AND",
      "rules": [
        { "field": "CustomerID", "op": "bw", "data": "W" },
        { "field": "Freight", "op": "le", "data": "1"}
      ]
}';

$template2 =
'{ "groupOp": "AND",
      "rules": [
        { "field": "ShipName", "op": "eq", "data": "Alfreds Futterkiste" },
        { "field": "OrderID", "op": "le", "data": "10800"}
      ]
}';

// In order to enable the more complex search we should set multipleGroup option
// Also we need show query too
$grid->setNavOptions('search', array(
	"multipleGroup"=>true,
	"showQuery"=>true,
	// set the names of the template
	"tmplNames"=>array("Template One", "Template Two"),
	// set the template contents
	"tmplFilters"=>array($template1, $template2)
));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
