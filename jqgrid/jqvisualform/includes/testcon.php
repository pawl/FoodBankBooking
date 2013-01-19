<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'connections.php';
include_once '../php/jqUtils.php';
	
$connstr = jqGridUtils::GetParam('conn');
$dbtype = jqGridUtils::GetParam('dbtype');
$action = jqGridUtils::GetParam('action');
$sqlstr = jqGridUtils::GetParam('sqlstring');
//var_dump($sqlstr);
if($action == 'test') {
	if($dbtype == 'mysql' || $dbtype=='pgsql' || $dbtype=='sqlite') {
		echo pdo_test_connection($connstr, $dbtype);
	}
}
//	var_dump($action);
if($action == 'genform') {
	if($dbtype == 'mysql' || $dbtype=='pgsql' || $dbtype=='sqlite')
	{
		include '../php/jqGridPdo.php';
		ini_set("display_errors",1);
		$info = parse_connection_string($connstr);
		
		try {
			$conn = new PDO($dbtype.':host='.$info->host.';dbname='.$info->database,$info->user_id, $info->password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sqlstr = jqGridDB::limit($sqlstr, $dbtype, 1, 0);
			//var_dump($sqlstr);
			$stmt = jqGridDB::prepare($conn, $sqlstr, null);
			$ret = jqGridDB::execute($stmt);
			$metasql = array();
			if($ret) {
				$meta = array();
				$colcount = jqGridDB::columnCount($stmt,null);
					
				for($i=0;$i<$colcount;$i++) {
					$meta = jqGridDB::getColumnMeta($i,$stmt);
					$metasql[] = array("name"=>$meta['name'], "type"=>jqGridDB::MetaType($meta,$dbtype),"len"=>$meta['len']);
				}
			}
			jqGridDB::closeCursor($stmt);

			echo json_encode(array("msg"=>"success", "rows" => $metasql) );
		} catch (Exception $e) {
			echo json_encode(array("msg"=>$e->getMessage()));
		}
	}
}
?>
