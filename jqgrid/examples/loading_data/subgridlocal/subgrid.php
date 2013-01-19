<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
//require_once ABSPATH."php/jqGridPdo.php";
require_once ABSPATH."php/jqGridArray.php";




// Get the needed parameters passed from the main grid
// By default we add to postData subgrid and rowid parameters in the main grid
$subtable = jqGridUtils::Strip($_REQUEST["subgrid"]);
$rowid = jqGridUtils::Strip($_REQUEST["rowid"]);

// Custom connection and query
$myconn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
$myconn->query("SET NAMES utf8");
//execute the query specifical to your database
$sth = $myconn->prepare('SELECT OrderID, RequiredDate, ShipName, ShipCity, Freight FROM orders WHERE CustomerID = "'.$rowid.'"');
//$sth->bindParam(1,$rowid);
$sth->execute();
// get the data as array. Nothe the the customer array 
// is passed in the select command
$orders = $sth->fetchAll(PDO::FETCH_ASSOC);
// end of custom code

if(count($orders) == 0) return "[]";

// create the array connection
$conn = new jqGridArray();



if(!$subtable && !$rowid) die("Missed parameters");
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = "SELECT * FROM orders";
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('subgrid.php');
// Set some grid options
$grid->setGridOptions(array(
    "width"=>540,
    "rowNum"=>10,
    "sortname"=>"OrderID",
    "height"=>110,
    "postData"=>array("subgrid"=>$subtable,"rowid"=>$rowid)));
// Change some property of the field(s)
$grid->setColProperty("RequiredDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y"),
    "search"=>false
    )
);
$grid->navigator = true;
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>false));
// Enjoy
$subtable = $subtable."_t";
$pager = $subtable."_p";
$grid->renderGrid($subtable,$pager, true, null, null, true,true);
$conn = null;
?>
