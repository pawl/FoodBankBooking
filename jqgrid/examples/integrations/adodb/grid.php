<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
require_once ABSPATH."php/jqGridAdodb.php";
// include the driver class
define('ADODB_ASSOC_CASE', 2);
require_once ABSPATH."php/adodb5/adodb.inc.php";

// Connection to the server
$conn = ADONewConnection('mysqli');
if (!$conn->Connect('localhost',DB_USER,DB_PASSWORD,'northwind')) err($conn->ErrorNo(). $sep . $conn->ErrorMsg());

$conn->Execute("SET NAMES utf8");
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Data from this SQL is 1252 encoded, so we need to tell the grid
// Set the SQL Data source
$table = 'products';
$grid->SelectCommand ='SELECT * FROM '.$table;

// set the ouput format to XML
$grid->dataType = 'json';
// Let the grid create the model
$grid->setPrimaryKeyId("ProductID");
$grid->setColModel();
$grid->table = $table;
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
$grid->navigator = true;
$grid->setNavOptions('navigator',array("csv"=>true, "pdf"=>true));
$grid->setFilterOptions(array("stringResult"=>true));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
