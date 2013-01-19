<?php 
session_start();
require_once 'tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  
    <style type="text">
        html, body {
			margin: 0;			/* Remove body margin/padding */
			padding: 0;
		    overflow: hidden;	/* Remove scroll bars on browser window */
	        font-size: 62.5%;

        }
		body {
			font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
		}
    </style>
    <title>jqScheduler PHP Demo</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../../themes/redmond/jquery-ui-custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../themes/jquery.ui.tooltip.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../themes/jqscheduler.css" />
    <script src="../../js/jquery.js" type="text/javascript"></script>
    <script src="../../js/jquery-ui-custom.min" type="text/javascript"></script>
    <script src="../../js/jquery.jqScheduler.min.js" type="text/javascript"></script>
	
  </head>
  <body>
<!-- <div id="calendar" style="height: 900px;margin: 0 auto;width:1000px;font-size: 0.8em;"></div> -->
<?php require_once("eventcal.php");?>
<br/>
<?php tabs(array("eventcal.php"));?>
     
   </body>
</html>
