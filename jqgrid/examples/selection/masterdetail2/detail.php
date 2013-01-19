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
$rowid = jqGridUtils::GetParam('EmployeeID', 0);
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = "SELECT OrderID, RequiredDate, ShipName, ShipCity, Freight, EmployeeID FROM orders WHERE EmployeeID= ?";
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setPrimaryKeyId('OrderID');
$grid->setColModel(null, array((int)$rowid));
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
// on beforeshow form when add we get the customer id and set it for posting
$beforeshow = <<<BEFORE
function(formid)
{
var srow = jQuery("#grid").jqGrid('getGridParam','selrow');
if(srow) {
	var gridrow = jQuery("#grid").jqGrid('getRowData',srow);
	$("#CustomerID",formid).val(gridrow.CustomerID);
}
}
BEFORE;

// disable the CRUD buttons when we initialy load the grid
$initgrid = <<< INIT
jQuery("#add_detail").addClass("ui-state-disabled");
jQuery("#edit_detail").addClass("ui-state-disabled");
jQuery("#del_detail").addClass("ui-state-disabled");
INIT;


$grid->setJSCode($initgrid);
$grid->setColProperty("EmployeeID",array("hidden"=>false,"width"=>20));
$grid->navigator = true;
$grid->setNavOptions('navigator', array("excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>false));
$grid->setNavEvent('add', 'beforeShowForm', $beforeshow);
// Enjoy
$summaryrow = array("Freight"=>array("Freight"=>"SUM"));
$grid->renderGrid("#detail","#pgdetail", true, $summaryrow, array((int)$rowid), true,true);
$conn = null;
?>
