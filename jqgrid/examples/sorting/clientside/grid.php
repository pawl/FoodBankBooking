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
$grid->SelectCommand = 'SELECT OrderID, OrderDate, CustomerID, Freight, ShipName FROM orders';
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set the initial sorting column using the sortname oprion
$grid->setGridOptions(array("sortname"=>"OrderID","rowNum"=>10,"rowList"=>array(10,20,30)));
// Change some property of the field(s)
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
    )
);
$sorcol = <<< ONSORTCOL
function (fieldName, columnIndex, sortOrder)
{
// fieldName is the DataField of the column being sorted
// columnIndex is the index of the column (zero bazed)
// sortOrder is a string "asc" or "desc"
var line = "<b>Column sorted</b>: " + fieldName + "; Index: " + columnIndex + "; sortOrder: " + sortOrder + "<br/>";
$("#log").append(line);
}
ONSORTCOL;
$grid->setGridEvent('onSortCol', $sorcol);
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
