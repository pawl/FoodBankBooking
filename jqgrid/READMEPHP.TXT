jqGrid for PHP - quick installation guide

System Requirments.
1. PHP 5.1 or higger
2. PDO installed driver (MySQL or PostgreSQL) - in the example we use MySQL
3. Web Server
4. Web browser

Download jqGrid for PHP from http://www.trirand.net/download.aspx. The package contains all files needed to begin working with the component.  The directory structure is as follows:
	- examples
	- js
	- php
	- themes
	- northwindSQL

The "examples" folder contains all the examples.
The "js" folder contains all the needed javascript files - jquery library, jqgrid library and jQuery UI javascript files.
The "php" folder contains the jqGrid PHP files - this is the component library of jqGrid for PHP. 
The "themes" directory contain by default the redmond theme used into the examples. You can download additional themes from jQuery UI's site (currently 25 themes available) or roll your own theme using the superb ThemeRoller tool.
The "northwindSQL" folder contains MySQL script for the sample Northwind database we are using.


1. Import the nortwind database in your MySQL server. The Northwind database create script (northwind.sql) is located in the "northwindSQL" folder of the installation package. 
2. Open the jq-config.php file and enter the needed information - database user and password. If you have used an alternative database name for the northwind database change the name by modifying the DB_DSN variable in jq-config.php
3. Make sure you have unzipped the contents of the installation zip package to the folder you will be using as a sample (or you can use our own structure).
4. In order to create quick test example create a php file in the root directory and name it (for example) myjqgridphp.php (can be any other name ending with php extension)
5. Here is a sample setup to be used in the test myjqgridphp.php file:

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>My First PHP jqGrid </title>

	<link rel="stylesheet" type="text/css" media="screen" href="themes/redmond/jquery-ui-1.8.2.custom.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="themes/ui.jqgrid.css" />

	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>

</head>
<body>
	......
	<?php include "myfirstgrid.php" ?>
	.......
</body>
</html>

Create the file myfirstgrid.php in the same directory and use the following code:

<?php
require_once 'jq-config.php';
// include the jqGrid Class
require_once "php/jqGrid.php";
// include the PDO driver class
require_once "php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT OrderID, OrderDate, CustomerID, Freight, ShipName FROM orders';
// set the ouput format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('myfirstgrid.php');
// Set grid caption using the option caption
$grid->setGridOptions(array(
    "caption"=>"This is custom Caption",
    "rowNum"=>10,
    "sortname"=>"OrderID",
    "hoverrows"=>true,
    "rowList"=>array(10,20,50),
    ));
// Change some property of the field(s)
$grid->setColProperty("OrderID", array("label"=>"ID", "width"=>60));
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
    )
);
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>

That is all that is needed to get you started.

6. If you find that jqGrid does not create the table and pager elements automatically - open the myjqgridphp.php and add the following

.....
<body>
......
<table id='grid'></table>
<div id='pager'></div>
<?php include "myfirstgrid.php" ?>
.......
</body>

then instruct renderGrid in myfirstgrid.php not to create the elements - this is done setting the last two parameters to false - i.e. 
$grid->renderGrid('#grid','#pager',true, null, null, false,false);

7. You can also place the generated jqGrid configuration in document ready function. For this purpose you will need to include the "myfirstgrid.php" in the script section and instruct renderGrid not to create the script tag automatically

Changes in myjqgridphp.php:

....
<script type="text/javascript">
jQuery(document).ready(function(){
.....

<?php include "myfirstgrid.php" ?>
...
});
</script>
</head>
<body>
......
<table id='grid'></table>
<div id='pager'></div>
.......
</body>
</html>

Changes in myfirstgrid.php - the third parameter instructs jqGrid not to generate the script tag.
....
$grid->renderGrid('#grid','#pager',false, null, null, false,false);

8. There are almost 50 examples in the "examples" folder where you can see how to use jqGrid in advanced scenarios, like adding / editing /deleting data, search, toolbar customizations, etc.

9. If you have any questions, write in our forums:
http://www.trirand.net/forum/

Kind Regards,
jqGrid Team