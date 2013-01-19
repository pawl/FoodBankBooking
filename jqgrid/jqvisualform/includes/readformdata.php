<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set("display_errors","1");
$doc = new DOMDocument();
$ret = $doc->load( 'testFile.xml' );
$rows = $doc->getElementsByTagName( "row" );
$md = array();
foreach( $rows as $row )
{
  $ids = $row->getElementsByTagName( "id" );
  $md['id'] = $ids->item(0)->nodeValue;
  
  $props= $row->getElementsByTagName( "prop" );
  $md['prop']= json_decode($props->item(0)->nodeValue, true);

  $names = $row->getElementsByTagName( "fldname" );
  $md['name'] = $names->item(0)->nodeValue;
  
    
  //echo "<b>$id - $prop\n</b><br>";
  //var_dump($rows);
} 
//var_dump($md);
$str = "";
$the_name   = "$".$md['name'];
$str = $the_name." = new jqForm();"."\n";
$str .= $the_name."->setFormProperties('".$md['name']."',array(";
$i=0;
foreach( $md['prop'] as $k=>$v)
{
	if($i==0) {
		$str .= "'".$k."' => '".$v."'";
	} else {
		$str .= ", '".$k."' => '".$v."'";
	}
	$i++;
}
$str .= ");";
echo($str);
?>
