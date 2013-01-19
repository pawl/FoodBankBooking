<?php
ini_set("display_errors",1);

require_once '../../../jq-config.php';
// include the driver class
require_once ABSPATH."php/jqGridPdo.php";
// include the jqGrid Class
require_once ABSPATH."php/jqTreeGrid.php";


// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");
// Create the jqTreeGrid instance
$tree = new jqTreeGrid($conn);

$tree->SelectCommand = "SELECT * FROM adj_table";

// set the table and primary key
$tree->table = 'adj_table';
$tree->setPrimaryKeyId('emp_id');
// set tree model and table configuration
$tree->setTreeModel('adjacency');
$tree->setTableConfig(array('id'=>'emp_id', 'parent'=>'boss_id'));

// autoloading is disabled
$tree->autoLoadNodes = false;
// collapse all nodes (default)
$tree->expandAll = true;
// show any error (if any ) from server
$tree->showError = true;

$tree->setColModel();

$tree->setUrl('treegrid.php');
$tree->dataType = 'json';
// Some nice setting
$tree->setColProperty('name',array("label"=>"Employee", "width"=>170));
$tree->setColProperty('salary',array("label"=>"Salary", "align"=>"right","width"=>90));

// hide the not needed fields
$tree->setColProperty('emp_id',array("hidden"=>true));
$tree->setColProperty('boss_id',array("hidden"=>true));

// and finaly set the expand column and height to auto
$tree->setGridOptions(array(
	"ExpandColumn"=>"name",
	"height"=>'auto',
	"sortname"=>"emp_id",
	// allow automatic scrolling of the rows
	"scrollrows"=>true
	));
// enable key navigation
$tree->callGridMethod('#tree', 'bindKeys');

$tree->navigator = true;
$tree->setNavOptions('navigator', array("add"=>true,"edit"=>true, "del"=>true, "search"=>false, "excel"=>false));
$tree->renderTree('#tree', '#pager', true,null, null, true, true);
?>
