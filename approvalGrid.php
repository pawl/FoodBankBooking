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
				$grid->SelectCommand = 'SELECT * FROM VOLUNTEER_LIST WHERE Is_Verified=0 order by Time_Start';

				// set the ouput format to json
				$grid->dataType = 'json';
				// Let the grid create the model
				$grid->setColModel();

				// Set the url from where we obtain the data
				$grid->setUrl('approvalGrid.php');
				// Set grid caption using the option caption
				$grid->setGridOptions(array(
					"caption"=>"Volunteer Requests",
					"rowNum"=>15,
					"rowList"=>array(10,15,20,50),
					"height"=>450,
					"width" => 1050
					));
				

				// Run the script
				$grid->renderGrid('#grid','#pager',true, null, null, true,true);
				$conn = null;
			?>