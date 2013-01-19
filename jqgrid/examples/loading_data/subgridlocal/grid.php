<?php
ini_set("display_errors",1);
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridArray.php";


// Connection to to your server server
$myconn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);

function get_main_grid(){
global $myconn, $customers;
$myconn->query("SET NAMES utf8");
//execute the query specifical to your database
$sth = $myconn->prepare('SELECT CustomerID, CompanyName, ContactName, Phone, City FROM customers');
$sth->execute();
// get the data as array. Nothe the the customer array 
// is passed in the select command
$customers = $sth->fetchAll(PDO::FETCH_ASSOC);
// end of custom code
//var_dump($customers);
// create the array connection
$conn = new jqGridArray();
// Create the jqGrid instance
$grid = new jqGridRender($conn); 

// Write the SQL Query
$grid->SelectCommand = 'SELECT * FROM customers';
// Set the table to where you update the data
$grid->table = 'customers';
// Set output format to json
$grid->dataType = 'json';
$grid->setPrimaryKeyId("CustomerID");
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>10,
    "height"=>250,
    "rowList"=>array(10,20,30),
    "sortname"=>"CustomerID"
));
$grid->setColProperty('CustomerID', array("label"=>"ID", "width"=>50));
$grid->setSubGridGrid("subgrid.php");
// Enable navigator
$grid->navigator = true;
// Enable only editing
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>false));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
}

//call the function
get_main_grid();
?>
