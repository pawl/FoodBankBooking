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
$grid->SelectCommand = 'SELECT a.OrderID, a.OrderDate, a.CustomerID, b.CompanyName, a.Freight, a.ShipName FROM orders a, customers b WHERE a.CustomerID=b.CustomerId';
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
    "caption"=>"Advanced Autocomplete",
    "rowNum"=>10,
    "sortname"=>"OrderID",
    "hoverrows"=>true,
    "rowList"=>array(10,20,50),
    ));
// Change some property of the field(s)
$grid->setColProperty("OrderID", array("label"=>"ID", "width"=>60));
$grid->setColProperty("CustomerID", array("editoptions"=>array("readonly"=>"readonly")));
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
    )
);
// set autocomplete. Serch for name and ID, but select a ID
// set it only for editing and not on serch
$grid->setAutocomplete("CompanyName","#CustomerID","SELECT CompanyName, CompanyName,CustomerID FROM customers WHERE CompanyName LIKE ? ORDER BY CompanyName",null,true,false);
$grid->datearray = array('OrderDate');
// Enjoy
$grid->navigator = true;
$grid->setNavOptions('navigator', array("search"=>false, "excel"=>false));
$grid->setNavOptions('edit', array("height"=>'auto',"dataheight"=>'auto'));
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;


?>
