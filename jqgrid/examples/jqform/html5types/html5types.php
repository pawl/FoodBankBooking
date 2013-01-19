<?php
// Include class 
include_once 'jqformconfig.php'; 
include_once $CODE_PATH.'jqUtils.php'; 
include_once $CODE_PATH.'jqForm.php'; 
// Create instance 
$newForm = new jqForm('newForm',array('enctype' => 'multipart/form-data', 'method' => 'post', 'id' => 'newForm'));
// Demo Mode creating connection 
include_once $CODE_PATH.'jqGridPdo.php'; 
$conn = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
$newForm->setConnection( $conn );
// Set url
$newForm->setUrl($SERVER_HOST.$SELF_PATH.'html5types.php');
// Set Form header 
$formhead='Shipping Details';
$newForm->setFormHeader($formhead,'ui-icon-mail-closed');
// Set parameters 
$jqformparams = array();
// Set SQL Command, table, keys 
$newForm->table = 'orders';
$newForm->setPrimaryKeys('OrderID');
$newForm->serialKey = true;
// Set Form layout 
$newForm->setColumnLayout('twocolumn');
$newForm->setTableStyles('width:580px;','','');
// Add elements
$newForm->addElement('OrderID','hidden', array('label' => 'OrderID', 'id' => 'newForm_OrderID'));
$newForm->addElement('ShipName','text', array('label' => 'Name', 'maxlength' => '40', 'placeholder' => 'Enter Ship name', 'style' => 'width:98%;', 'id' => 'newForm_ShipName'));
$newForm->addElement('ShipAddress','text', array('label' => 'Address', 'maxlength' => '60', 'placeholder' => 'Enter Ship Address', 'style' => 'width:98%;', 'id' => 'newForm_ShipAddress'));
$newForm->addElement('ShipCity','text', array('label' => 'City', 'maxlength' => '15', 'size' => '20', 'placeholder' => 'Enter Ship City', 'id' => 'newForm_ShipCity'));
$newForm->addElement('ShipPostalCode','text', array('label' => 'PostalCode *', 'maxlength' => '10', 'size' => '20', 'pattern' => '^[\d]{5}(-[\d]{4})?$', 'placeholder' => 'Enter 5 or 9 digit postal code', 'title' => 'Enter valid postal code', 'id' => 'newForm_ShipPostalCode'));
$newForm->addElement('ShipCountry','text', array('label' => 'Country', 'maxlength' => '15', 'size' => '20', 'id' => 'newForm_ShipCountry'));
$newForm->addElement('Freight','number', array('label' => 'Freight', 'min' => '0.1', 'max' => '40', 'step' => '0.5', 'id' => 'newForm_Freight'));
$newForm->addElement('email','email', array('label' => 'Email ', 'style' => 'width:98%;', 'id' => 'newForm_email'));
$newForm->addElement('url','url', array('label' => 'Company Url', 'style' => 'width:98%;', 'id' => 'newForm_url'));
$elem_10[]=$newForm->createElement('newSubmit','submit', array('value' => 'Submit'));
$newForm->addGroup("newGroup",$elem_10, array('style' => 'text-align:right;', 'id' => 'newForm_newGroup'));
// Add events
// Add ajax submit events
$newForm->setAjaxOptions( array('dataType'=>'html',
'resetForm' =>null,
'clearForm' => null,
'iframe' => false,
'forceSync' =>false) );
// Demo mode - no input 
$newForm->demo = true;
// Render the form 
echo $newForm->renderForm($jqformparams);
?>