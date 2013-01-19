<?php
require_once '../../../jq-config.php';
require_once ABSPATH."php/jqGridPdo.php";
$country = $_GET['q'];
if($country){
	try {
		$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
		$SQL =  "SELECT DISTINCT(City) id, City value FROM customers WHERE Country='".$country."' ORDER BY City";
		$collation = jqGridDB::query($conn, "SET NAMES utf8");
		$city = jqGridDB::query($conn, $SQL);
		$result = jqGridDB::fetch_object($city, true, $conn);
		echo json_encode($result);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}
?>
