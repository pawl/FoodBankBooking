<?php
include "sendEmails.php";

                    require "include.php";                   
                  
                  
                    $id = $_POST["data"];
					
					$query = "UPDATE VOLUNTEER_LIST SET Is_Verified=1 WHERE ID=" . $id;
                    //echo $query;
                    if(!mysql_query($query)) {
                          die(mysql_error());		
                    }
                    echo "Your request has been successfully entered, you will receive a confirmation shortly.";	
					
					$query = "select Email from VOLUNTEER_LIST where ID=" . $id;
                    //echo $query;
                    if(!$result = mysql_query($query)) {
                          die(mysql_error());		
                    }
					$row = mysql_fetch_assoc($result);
					SendEmails($row["Email"], "Confirmation", "You have been approved for to volunteer at North Texas Food Bank!", "confirm@ntfoodbank.com");
                ?>