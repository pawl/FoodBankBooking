<?php
//ini_set("display_errors","1");
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";
// include the driver class
require_once ABSPATH."php/jqGridArray.php";

// create the array connection
$conn = new jqGridArray();
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Create a random array data
for ($i = 0; $i < 1000; $i++)
{
	$data1[$i]['id']	= $i+1;
	$data1[$i]['foo']	= md5(rand(0, 10000));
	$data1[$i]['bar']	= 'bar'.($i+1);
}

// Always you can use SELECT * FROM data1
$grid->SelectCommand = "SELECT id, foo, bar FROM data1";

$grid->dataType = 'json';
$grid->setPrimaryKeyId('id');

$grid->setColModel();
// Enable navigator

$grid->setUrl('grid.php');

$grid->setGridOptions(array(
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"id"
));

$grid->navigator = true;
// Enable search
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>false,"csv"=>true, "pdf"=>true));
// Activate single search
$grid->setNavOptions('search',array("multipleSearch"=>false));
// Enjoy

$grid->renderGrid('#grid','#pager',true, null, null, true,true);

?>
