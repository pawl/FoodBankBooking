<?php
require_once '../../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/jqGrid.php";

// Create the jqGrid instance
$grid = new jqGridRender();
// Lets create the model manually
$Model = array(
    array("name"=>"Integer", "editable"=>true,"sorttype"=>"integer",
        "editrules"=>array("required"=>true, "integer"=>true, "minValue"=>100,"maxValue"=>1000) ),
    array("name"=>"Number","editable"=>true,"sorttype"=>"number",
        "editrules"=>array("required"=>true, "number"=>true, "minValue"=>0,"maxValue"=>10000) ),
    array("name"=>"Currency","editable"=>true, "sorttype"=>"number",
        "editrules"=>array("required"=>true, "number"=>true, "minValue"=>0)),
    array("name"=>"Email","editable"=>true,
        "formatter"=>"email",
        "editrules"=>array("email"=>true)
        ),
    array("name"=>"Link","editable"=>true,
        "width"=>120,
        "formatter"=>"link",
        "editrules"=>array("url"=>true)
        ),
);
// Let the grid create the model
$grid->setColModel($Model);
// Set grid option datatype to be local and editurl to point to dummy file
$grid->setGridOptions(array("datatype"=>"local", "editurl"=>"dummy.txt"));
//We can add data manually using arrays
$data = array(
    array("Integer"=>200000,"Number"=>60000000.73,"Currency"=>34.2,"Email"=>"john.smith@yahoo.com","Link"=>"http://www.yahoo.com"),
    array("Integer"=>1600000,"Number"=>75200000.23,"Currency"=>245.2,"Email"=>"joe.woe@google.com","Link"=>"http://www.google.com"),
    array("Integer"=>652693,"Number"=>34534000.33,"Currency"=>18545.2,"Email"=>"julia.bergman@bing.com","Link"=>"http://www.bing.com"),
    array("Integer"=>1237,"Number"=>3450.30,"Currency"=>55597545.2,"Email"=>"roy.corner@msn.com","Link"=>"http://www.msn.com")
);
// Let put it using the callGridMethod
$grid->callGridMethod("#grid", 'addRowData', array("Integer",$data));
$grid->navigator = true;
// Enable only editing
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>true,"del"=>false,"view"=>false, "search"=>false));
// Close the dialog after editing
$grid->setNavOptions('edit',array("closeAfterEdit"=>true,"reloadAfterSubmit"=>false));

$grid->renderGrid('#grid','#pager',true, null, null, true,true);
?>
