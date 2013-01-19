<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// MySQL specific command for the charset
$conn->query("SET NAMES utf8");
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Data from this SQL is 1252 encoded, so we need to tell the grid
// Set the data source to be read from file
$grid->readFromXML = true;
// The first item is the xml file, the second is the query id
$grid->SelectCommand ='sqlxml.getProducts';
// set the ouput format to XML
$grid->dataType = 'xml';
// Let the grid create the model
$grid->setColModel();
// set labels in the header
$grid->setColProperty("ProductID", array("label"=>"ID"));
$grid->setColProperty("ProductName", array("label"=>"Name"));
$grid->setColProperty("QuantityPerUnit", array("label"=>"Unit"));
$grid->setColProperty("UnitPrice", array("label"=>"Unit Price"));
// We can hide some columns
$grid->setColProperty("SupplierID", array("hidden"=>true));
$grid->setColProperty("CategoryID", array("hidden"=>true));
$grid->setColProperty("UnitsOnOrder", array("hidden"=>true));
$grid->setColProperty("ReorderLevel", array("hidden"=>true));
$grid->setColProperty("Discontinued", array("hidden"=>true));
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array("rowNum"=>10,"rowList"=>array(10,20,30),"sortname"=>"CategoryID"));
// Enable toolbar searching
$grid->toolbarfilter = true;
$grid->setFilterOptions(array("stringResult"=>true));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
