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
$grid->SelectCommand = 'SELECT CustomerID, CompanyName, Phone, PostalCode, City FROM customers';
// Set the table to where we add the data
$grid->table = 'customers';
// We tell that the primary key is not serial, which should be inserted by the user
$grid->serialKey = false;
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
    "sortname"=>"CustomerID"
));
// The primary key should be entered
$grid->setColProperty('CustomerID', array("editrules"=>array("required"=>true)));
// Enable navigator
$grid->navigator = true;
// Enable only adding
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>true,"edit"=>false,"del"=>false,"view"=>false, "search"=>false));
// Close the dialog after the record is added
$grid->setNavOptions('add',array("closeAfterAdd"=>true,"reloadAfterSubmit"=>false));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
