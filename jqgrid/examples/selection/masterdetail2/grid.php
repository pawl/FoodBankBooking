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
$grid->SelectCommand = 'SELECT EmployeeID, FirstName, LastName, HomePhone, City FROM employees';
// Set the table to where you update the data
$grid->table = 'employees';
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
    "sortname"=>"EmployeeID"
));
$grid->setColProperty('EmployeeID', array("label"=>"ID", "width"=>50));

$selectorder = <<<ORDER
function(rowid, selected)
{
    if(rowid != null) {
        jQuery("#detail").jqGrid('setGridParam',{postData:{EmployeeID:rowid}});
        jQuery("#detail").trigger("reloadGrid");
		// Enable CRUD buttons in navigator when a row is selected
		jQuery("#add_detail").removeClass("ui-state-disabled");
		jQuery("#edit_detail").removeClass("ui-state-disabled");
		jQuery("#del_detail").removeClass("ui-state-disabled");
    }
}
ORDER;
// We should clear the grid data on second grid on sorting, paging, etc.
$cleargrid = <<<CLEAR
function(rowid, selected)
{
   // clear the grid data and footer data
	jQuery("#detail").jqGrid('clearGridData',true);
	// Disable CRUD buttons in navigator when a row is not selected
	jQuery("#add_detail").addClass("ui-state-disabled");
	jQuery("#edit_detail").addClass("ui-state-disabled");
	jQuery("#del_detail").addClass("ui-state-disabled");
}
CLEAR;

$grid->setGridEvent('onSelectRow', $selectorder);
$grid->setGridEvent('onSortCol', $cleargrid);
$grid->setGridEvent('onPaging', $cleargrid);
// Enable navigator
$grid->navigator = true;
// Enable only editing
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>false));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
