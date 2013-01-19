<?php
                  require "include.php";                  
                  
                  
                    $id = $_POST["data"];
					
					$query = "UPDATE VOLUNTEER_LIST SET Is_Verified=1 WHERE ID=" . $id;
                    //echo $query;
                    if(!mysql_query($query)) {
                          die(mysql_error());		
                    }
                    echo "Your request has been successfully entered, you will receive a confirmation shortly.";	
                ?>