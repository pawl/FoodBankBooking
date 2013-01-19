<?php
				// include the jqGrid Class 
				require_once "jqgrid/php/jqGrid.php"; 
				// include the driver class 
				// Connection to the server 		
			require_once "jqgrid/php/jqGridPdo.php"; 		

                  $conn = new PDO("mysql:host=localhost;dbname=ntfoodba_contact", "root", 'secret') or die(mysql_error());
				// Create the jqGrid instance 
				$conn->query("SET NAMES utf8"); 
				$grid = new jqGridRender($conn); 
				// Write the SQL Query 
				$tomorrow = date('Y-m-d',mktime(0,0,0,date('m'), date('d')+1, date('Y')));
				$dayAfter = date('Y-m-d',mktime(0,0,0,date('m'), date('d')+2, date('Y')));
				
				$grid->SelectCommand = "SELECT CONCAT( First_Name,  ' ', Last_Name ) As Name, Number_Of_People, Phone_Number, Email, Time_Start Start_Time
FROM VOLUNTEER_LIST WHERE Time_Start > '" . $tomorrow . ' AND TIME_END < "' . $dayAfter . "'";

				// set the ouput format to json
				$grid->dataType = 'json';
				// Let the grid create the model
				$grid->setColModel();

				// Set the url from where we obtain the data
				$grid->setUrl('grid.php');
				// Set grid caption using the option caption
				$grid->setGridOptions(array(
					"caption"=>"People Who Volunteer Tomorrow",
					"rowNum"=>15,
					"rowList"=>array(10,15,20,50),
					"height"=>345,
					"width" => 1050,
					));


				// Run the script
				$grid->renderGrid('#grid','#pager',true, null, null, true,true);
				$conn = null;
			?>