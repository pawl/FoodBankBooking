<?php 
require_once '../../../tabs.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>jqTreeGrid PHP Demo</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../../../themes/redmond/jquery-ui-custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../themes/ui.jqgrid.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../themes/ui.multiselect.css" />
    <style type="text">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	padding: 0;
        overflow: hidden;	/* Remove scroll bars on browser window */
        font-size: 75%;
        }
		tr.jqgrow td {border-bottom-width: 0px; border-bottom-color: inherit; border-bottom-style: none;}
		.ui-jqgrid tr.ui-row-ltr td {text-align:left;border-right-width: 0px !important; border-right-color: inherit; border-right-style: none;}
    </style>
    <script src="../../../js/jquery.js" type="text/javascript"></script>
    <script src="../../../js/i18n/grid.locale-en.js" type="text/javascript"></script>
	<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
	</script>
    <script src="../../../js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="../../../js/jquery-ui-custom.min.js" type="text/javascript"></script>
  </head>
  <body>
      <div>
          <?php include ("treegrid.php");?>
      </div>
	  <div id="selection">
		  price:
		  <span id="price"></span><br/>
		  icon: <span id="uiicon"></span>
	  </div>
      <br/>
      <?php tabs(array("treegrid.php"));?>
   </body>
</html>
