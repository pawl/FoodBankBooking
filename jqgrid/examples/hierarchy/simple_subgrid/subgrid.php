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
$rowid = jqGridUtils::GetParam("id");
if(!$rowid) die("Missed parameters");
// Create the base jqGrid instance
$grid = new jqGrid($conn);
// Write the SQL Query
$grid->SubgridCommand = "SELECT OrderID, RequiredDate, ShipName, ShipCity, Freight FROM orders WHERE CustomerID=? ORDER BY OrderID desc";
// set the ouput format to json
$grid->dataType = 'json';
// Use the build in function for the simple subgrid
$grid->querySubGrid(array(&$rowid));
$conn = null;
?>
