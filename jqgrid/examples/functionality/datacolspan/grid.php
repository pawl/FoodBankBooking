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
$grid->SelectCommand = 'SELECT EmployeeID, TitleOfCourtesy, LastName, FirstName, BirthDate, City, Region FROM employees';
// Set the table to where you add the data
$grid->table = 'employees';
// Set output format to json
$grid->dataType = 'json';
//$grid->usertimeformat = "d/m/Y";
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// add a action column and instruct the formatter to create the needed butons
// for inline editing
$grid->setColProperty('EmployeeID', array("editable"=>false, "width"=>50, "label"=>"ID"));
$grid->setColProperty('TitleOfCourtesy', array("hidden"=>true));
$grid->setColProperty('LastName', array(
	"cellattr"=>"js:function( rowId, value, rowObject, colModel, arrData){ return ' colspan=2'}",
	"formatter"=>"js:function(value, options, rData){ return rData['TitleOfCourtesy'] + ' ' + value +', '+ rData['FirstName'];}"
));
$grid->setColProperty('FirstName', array(
	"cellattr"=>"js:function( rowId, value, rowObject, colModel, arrData){ return ' style=\"display:none\"'}"
));
$grid->setColProperty('BirthDate', 
        array("formatter"=>"date",
            "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s", "newformat"=>"m/d/Y h:i A"),
// Ok. We use some trick here to create the datepicer on dataInit event
// when the element is created. Note the js: before the function.
// this instruct the grid to put a javascript code without additional formating
            "editoptions"=>array("dataInit"=>
                "js:function(elm){setTimeout(function(){
                    jQuery(elm).datepicker({dateFormat: 'm/d/yy',timeFormat: 'hh:mm TT',separator: ' ' ,ampm: true});
                    jQuery('.ui-datepicker').css({'font-size':'75%'});
                },200);}")
            ));
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"EmployeeID"
));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
