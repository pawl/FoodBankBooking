<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set("display_errors","1");
$fname = $_POST['fname'];
$fh = fopen($fname, 'r');
$theData = fread($fh, filesize($fname));
fclose($fh);
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") )
{
	header("Content-type: application/xhtml+xml;charset=utf-8");
} else {
	header("Content-type: text/xml;charset=utf-8");
}
echo $theData;
?>
