<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// include the autocomplete class
require_once ABSPATH."php/jqAutocomplete.php";

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
$grid->table ="orders";
$grid->setPrimaryKeyId("OrderID");
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set grid caption using the option caption
$grid->setGridOptions(array(
    "caption"=>"Autocomplete in serch dialog",
    "rowNum"=>10,
    "sortname"=>"OrderID",
    "hoverrows"=>true,
    "rowList"=>array(10,20,50),
    ));
// Change some property of the field(s)
$grid->setColProperty("OrderID", array("label"=>"ID", "width"=>60));
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
    )
);
// set autocomplete. Serch for name and ID, but select a ID
// set it only for editing and not on search
// Set autocomplete only on serch form.
$grid->setAutocomplete("ShipName",false,"SELECT DISTINCT ShipName FROM orders WHERE ShipName LIKE ? ORDER BY ShipName",null, false ,true);
$grid->datearray = array('OrderDate');
// Enjoy
$grid->navigator = true;
$grid->setNavOptions('navigator', array("search"=>true, "excel"=>false, "edit"=>false, "add"=>false, "del"=>false));
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
