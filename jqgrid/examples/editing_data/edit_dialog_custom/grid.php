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
// Set the table to where you update the data
$grid->table = 'customers';
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
// Set the custom code for the fields
$grid->setColProperty('CustomerID', array("editoptions"=>array("readonly"=>true)));
$grid->setColProperty('Phone',array("formoptions"=>array("rowpos"=>1,"colpos"=>2)));
$grid->setColProperty('CompanyName',array(
    "formoptions"=>array("label"=>"Company", "elmsuffix"=>"(required)"),
    "editrules"=>array("required"=>true))
);

// Enable navigator
$grid->navigator = true;
// Enable only editing
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>true,"del"=>false,"view"=>false, "search"=>false));
// Some options for the edit
$grid->setNavOptions('edit',array("closeAfterEdit"=>true,"width"=>470,"height"=>170,"dataheight"=>100));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
