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
// Get the needed parameters passed from the main grid
if(isset ($_REQUEST["CustomerID"]))
    $rowid = jqGridUtils::Strip($_REQUEST["CustomerID"]);
else
    $rowid = "";
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = "SELECT OrderID, RequiredDate, ShipName, ShipCity, Freight FROM orders WHERE CustomerID= ?";
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel(null, array(&$rowid));
// Set the url from where we obtain the data
$grid->setUrl('detail.php');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>10,
    "footerrow"=>true,
    "userDataOnFooter"=>true,
    "sortname"=>"OrderID",
    "height"=>110
    ));
// Change some property of the field(s)
$grid->setColProperty("RequiredDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y"),
    "search"=>false
    )
);
$grid->navigator = true;
$grid->setNavOptions('navigator', array("excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>false));
// Enjoy
$summaryrow = array("Freight"=>array("Freight"=>"SUM"));
$grid->renderGrid("#detail","#pgdetail", true, $summaryrow, array(&$rowid), true,true);
$conn = null;
?>
