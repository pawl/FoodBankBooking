<?php
// Include class 
include_once 'jqformconfig.php'; 
include_once $CODE_PATH.'jqUtils.php'; 
include_once $CODE_PATH.'jqForm.php'; 
// Create instance 
$newForm = new jqForm('newForm',array('method' => 'post', 'id' => 'newForm'));
// Demo Mode creating connection 
include_once $CODE_PATH.'jqGridPdo.php'; 
$conn = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
$newForm->setConnection( $conn );
// Set url
$newForm->setUrl($SERVER_HOST.$SELF_PATH.'sqlcheckdata.php');
// Set Form header 
$formhead='Edit Ship Details';
$newForm->setFormHeader($formhead,'ui-icon-pencil');
// Set parameters 
$Order = jqGridUtils::GetParam('Order','10254');
$Order = is_numeric($Order) ? (int)$Order : 0;
$jqformparams = array($Order);
// Set SQL Command, table, keys 
$newForm->SelectCommand = 'SELECT OrderID, ShipName, ShipAddress, ShipCity, ShipPostalCode, ShipCountry, Freight FROM orders WHERE OrderID = ?';
$newForm->table = 'orders';
$newForm->setPrimaryKeys('OrderID');
$newForm->serialKey = true;
// Set Form layout 
$newForm->setColumnLayout('twocolumn');
$newForm->setTableStyles('width:580px;','','');
// Add elements
$newForm->addElement('OrderID','hidden', array('label' => 'OrderID', 'id' => 'newForm_OrderID'));
$newForm->addElement('ShipName','text', array('label' => 'ShipName', 'maxlength' => '40', 'style' => 'width:98%;', 'id' => 'newForm_ShipName'));
$newForm->addElement('ShipAddress','text', array('label' => 'ShipAddress', 'maxlength' => '60', 'style' => 'width:98%;', 'id' => 'newForm_ShipAddress'));
$newForm->addElement('ShipCity','text', array('label' => 'ShipCity', 'maxlength' => '15', 'size' => '20', 'id' => 'newForm_ShipCity'));
$newForm->addElement('ShipPostalCode','text', array('label' => 'ShipPostalCode', 'maxlength' => '10', 'size' => '20', 'id' => 'newForm_ShipPostalCode'));
$newForm->addElement('ShipCountry','text', array('label' => 'ShipCountry', 'maxlength' => '15', 'size' => '20', 'id' => 'newForm_ShipCountry'));
$newForm->addElement('Freight','number', array('label' => 'Freight', 'id' => 'newForm_Freight'));
$elem_8[]=$newForm->createElement('newSubmit','submit', array('value' => 'Submit'));
$newForm->addGroup("newGroup",$elem_8, array('style' => 'text-align:right;', 'id' => 'newForm_newGroup'));
// Add events
// Add ajax submit events
$beforeSubmit = <<< BS
function(arr, form, options) {
var Form = form[0];
if(Form.Freight.value > 20)
{
  alert("Please enter value less then 20");
  return false;
}
}
BS;
$newForm->setAjaxOptions( array('dataType'=>null,
'resetForm' =>null,
'clearForm' => null,
'beforeSubmit' =>'js:'.$beforeSubmit,
'iframe' => false,
'forceSync' =>false) );
// Demo mode - no input 
$newForm->demo = true;
// Render the form 
echo $newForm->renderForm($jqformparams);
?>