<?php 
require_once '../../../tabs.php';
if(isset ($_COOKIE["jqglang"]))
{
    $lang = $_COOKIE["jqglang"];
} else {
    $lang = "en";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>jqGrid PHP Demo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    </style>
    <script src="../../../js/jquery.js" type="text/javascript"></script>
    <script src="../../../js/jquery.cookie.js" type="text/javascript"></script>
    <script src="../../../js/i18n/grid.locale-<?php echo $lang;?>.js" type="text/javascript"></script>
	<script type="text/javascript">
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
	</script>
    <script src="../../../js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="../../../js/jquery-ui-custom.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            var lng = '<?php echo $lang;?>';
            $("#lang").val(lng).change(function(){
                var lng = $(this).val();
                if(lng) {
                    jQuery.cookie('jqglang',lng);
                    window.location.reload();
                }
            });
        });
    </script>
  </head>
  <body>
      <div style="margin-bottom: 10px">
      Select Language :
      <select id="lang">
          <option value="bg">Bulgarian</option>
          <option value="en">English</option>
          <option value="cat">Catalan</option>
          <option value="cn">Chinese</option>
          <option value="cs">Czech</option>
          <option value="de">German</option>
          <option value="dk">Danish</option>
          <option value="el">Greek</option>
          <option value="fa">Persian</option>
          <option value="fi">Finnish</option>
          <option value="fr">French</option>
          <option value="he">Hebrew</option>
          <option value="is">Icelandic</option>
          <option value="it">Italian</option>
          <option value="it">Japanese</option>
          <option value="nl">Holland</option>
          <option value="nl">Norwegian</option>
          <option value="nl">Polish</option>
          <option value="pt">Portuguese</option>
          <option value="pt-br">Brazilian-Portuguese</option>
          <option value="ro">Romanian</option>
          <option value="ru">Russian</option>
          <option value="sp">Spanish</option>
          <option value="sv">Swedish</option>
          <option value="tr">Turkish</option>
          <option value="ua">Ukrainian</option>
      </select>
      </div>
      <div>
          <?php include ("grid.php");?>
      </div>
      <br/>
      <?php tabs(array("grid.php"));?>
   </body>
</html>
