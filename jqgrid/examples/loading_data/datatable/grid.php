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
// this table is 1252 encoded, so we need to tell the grid
// Set the table data source
$grid->setTable('products');
// set the ouput format to xml since json have problems
$grid->dataType = 'xml';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array("rowNum"=>10,"rowList"=>array(10,20,30),"sortname"=>"ProductID"));
$grid->setColProperty("ProductID", array("width"=>80));

// We can hide some columns
$grid->setColProperty("SupplierID", array("hidden"=>true));
$grid->setColProperty("CategoryID", array("hidden"=>true));
$grid->setColProperty("UnitsOnOrder", array("hidden"=>true));
$grid->setColProperty("ReorderLevel", array("hidden"=>true));
$grid->setColProperty("Discontinued", array("hidden"=>true));
// Enable toolbar searching
$grid->toolbarfilter = true;
$grid->setFilterOptions(array("stringResult"=>true));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
