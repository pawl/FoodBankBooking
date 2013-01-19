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
$grid->SelectCommand = 'SELECT CustomerID, CompanyName, Phone, PostalCode, Country, City FROM customers';
// Set the table to where you update the data
$grid->table = 'customers';
$grid->setPrimaryKeyId("CustomerID");
$grid->serialKey = false;

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
    "sortname"=>"CustomerID"
));
$grid->setColProperty('CustomerID', array("editoptions"=>array("readonly"=>true)));
$grid->setColProperty('City', array("edittype"=>"select", "editoptions"=>array("value"=>" :Select")));
$grid->setSelect("Country","SELECT DISTINCT Country, Country FROM customers ORDER BY Country", true, true, false);
//$grid->setSelect("City","SELECT DISTINCT City, City FROM customers ORDER BY City", true, true, false);

// This event check if we are in add or edit mode and is lunched
// every time the form opens.
// The purpose of thris event is to get the value of the selected
// country and to get the values of the cityes for that country when the form is open.
// Another action here is to select the city from the grid
$beforeshow = <<< BEFORESHOW
function(formid)
{
    // get the value of the country
	var cntryval = $("#Country",formid).val();
	jQuery("#City",formid).html("<option>Select</option>");
	if(cntryval) {
	    // if the value is found try to use ajax call to obtain the citys
		// please look at file file city.php
		jQuery.ajax({
			url: 'city.php',
			dataType: 'json',
			data: {q:cntryval},
			success : function(response)
			{
				var t="", sv="";
				var sr = jQuery("#grid").jqGrid('getGridParam','selrow');
				if(sr)
				{
				    // get the selected city from grid
					sv = jQuery("#grid").jqGrid('getCell',sr,'City');
					jQuery.each(response, function(i,item) {
						t += "<option value='"+item.id+"'>"+item.value+"</option>";
					});
					// empty the select and put the new selection
					jQuery("#City",formid).html("").append(t);
					if(sv)
					{
					    // select the city value
						jQuery("#City",formid).val(sv).removeAttr("disabled");
					}
				}
			}
		});
	} else {
		jQuery("#City",formid).attr("disabled","disabled");
	}
}
BEFORESHOW;

// With this event we bind a change event for the first select.
// If a new value is selected we make ajax call and try to get the citys for this country
// Note that this event should be executed only once if the form is constructed.

$initform = <<< INITFORM
function(formid)
{
	jQuery("#Country",formid).change(function(e) {
		var cntryval = $(this).val();
		if(cntryval) {
			jQuery("#City",formid).html("");
			jQuery.ajax({
				url: 'city.php',
				dataType: 'json',
				data: {q:cntryval},
				success : function(response)
				{
					var t="";
					jQuery.each(response, function(i,item) {
						t += "<option value='"+item.id+"'>"+item.value+"</option>";
					});
					jQuery("#City",formid).append(t).removeAttr("disabled");
				}
			});
		}
	});
}
INITFORM;

// Enable navigator
$grid->navigator = true;
// Enable only editing
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>true,"edit"=>true,"del"=>false,"view"=>false, "search"=>false));
// Close the dialog after editing
$grid->setNavOptions('edit',array("closeAfterEdit"=>true,"editCaption"=>"Update Customer","bSubmit"=>"Update", "viewPagerButtons"=>false));
// Bind the before show Form event in add and edit mode.
$grid->setNavEvent('edit', 'beforeShowForm', $beforeshow);
$grid->setNavEvent('add', 'beforeShowForm', $beforeshow);
// Bind the initialize Form event in add and edit mode.
$grid->setNavEvent('edit', 'onInitializeForm', $initform);
$grid->setNavEvent('add', 'onInitializeForm', $initform);
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>
