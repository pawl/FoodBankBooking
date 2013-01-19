<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqCalendar.php";

require_once ABSPATH."php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT EmployeeID, FirstName, LastName, BirthDate FROM employees';
// Set the table to where you add the data
$grid->table = 'employees';
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
$grid->setColProperty('EmployeeID', array("editable"=>false));
$grid->setColProperty('BirthDate', 
        array("formatter"=>"date","formatoptions"=>array("srcformat"=>"Y-m-d H:i:s", "newformat"=>"Y-m-d")));
// Set some grid options
$grid->setUserTime("m/d/Y");
$grid->setDatepicker("BirthDate",array("buttonOnly"=>false));

$grid->setGridOptions(array(
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"EmployeeID"
));
// navigator first should be enabled
$grid->navigator = true;
$grid->setNavOptions('navigator', array("add"=>false,"edit"=>false,"excel"=>false, "search"=>false,"del"=>false, "refresh"=>false));
// and just enable the inline
$grid->inlineNav = true;
// disable editing - just adding
$grid->inlineNavOptions('navigator', array("edit"=>false) );

$grid->callGridMethod("#grid", 'setFrozenColumns');
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
