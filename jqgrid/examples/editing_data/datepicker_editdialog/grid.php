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
        array("formatter"=>"date",
            "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s", "newformat"=>"Y-m-d"),
            "editoptions"=>array("dataInit"=>
                "js:function(elm){setTimeout(function(){
                    jQuery(elm).datepicker({dateFormat:'yy-mm-dd'});
                    jQuery('.ui-datepicker').css({'zIndex':'1200','font-size':'75%'});},100);}")
            ));
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>10,
    "scrollrows"=>true,
    "rowList"=>array(10,20,30),
    "sortname"=>"EmployeeID"
));
$grid->navigator= true;
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>true,"edit"=>true,"del"=>false,"view"=>false, "search"=>false));
// Close the dialog after editing
$grid->setNavOptions('edit',array("height"=>150,"dataheight"=>'auto', "closeAfterEdit"=>true));
$grid->setNavOptions('add',array("height"=>150,"dataheight"=>'auto',"closeAfterEdit"=>true));

// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
