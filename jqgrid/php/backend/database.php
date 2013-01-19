<?php
/**
 * jqScheduler
 *
 * Database backend
 *
 * @version 1.0
 * @author Tony Tomov
 * @copyright (c) Tony Tomov
 */
require_once('backend.php');

final class Database extends Backend 
{
	private $db;
	private $table;
	private $user_id;
	private $dbmap = array(
		"event_id"=>"id", // this is a id key
		"title"=>"title",
		"start"=>"start",
		"end"=>"end",
		"description"=>"description",
		"location"=>"location",
		"categories"=>"className",
		"access"=>"access",
		"all_day"=>"allDay",
		"user_id"=>"user_id"
	);
	private $encoding = "utf-8";
	private $dbtype;
	// 
	private $searchwhere = "";
	private $searchdata = array();
	
	private $wherecond = "";
	private $whereparams = array();
	private $qout = "";


	public function __construct($db) {
		$this->db = $db;
	}
  
	public function setUser( $user) {
		if($user) {
			$this->user_id=$user;
		}
	}
	public function setTable( $table) {
		if($table) {
			$this->table=$table;
		}
	}
	public function setDbType( $dtype ) {
		$this->dbtype =$dtype;		
	}
	public function setSearchs( $where, array $whrval)
	{
		$this->searchwhere = $where;
		$this->searchdata = $whrval;
	}
	public function setWhere( $where, $param = array())
	{
		$this->wherecond = $where;
		$this->whereparams = $param;
	}
	public function setQuote( $q ) {
		$this->qout =$q;
	}

	public function newEvent( $data = array() )
	{
			//$start, $end, $title, $description, $location, $categories, $access, $allDay) {
		if (!empty($this->user_id) && !empty($this->table) ) {
			if(!isset($data['user_id'])) { return false; }
			if(is_array($this->user_id)) {
				if(!in_array($data['user_id'], $this->user_id)) { return false;}
			} else {
				if($data['user_id'] != $this->user_id) { return false; }
			}
			$tableFields = array_keys($this->dbmap);
			$binds = array();
			unset($tableFields['event_id']);
			$rowFields = array_intersect($tableFields, array_keys($data));
			foreach($rowFields as $key => $val)
			{
				$insertFields[] = "?";
            //$field;
				$value = $data[$val];
				if( strtolower($this->encoding) != 'utf-8' ) {
					$value = iconv("utf-8", $this->encoding."//TRANSLIT", $value);
				}
				if(in_array($val, array('user_id', 'start', 'end','all_day'))) {
					$value = (int)$value;
				}
				$binds[] = $value;
			}
			$sql = "";
			if(count($insertFields) > 0) {
				$sql = "INSERT INTO ".$this->qout.$this->table.$this->qout.
				" (".$this->qout . implode($this->qout.', '.$this->qout, $rowFields) .$this->qout.")" .
				" VALUES( " . implode(', ', $insertFields) . ")";

			}
			if(!$sql) return false;
			jqGridDB::beginTransaction($this->db);
			$query = jqGridDB::prepare($this->db, $sql, $binds);
			$ado = jqGridDB::execute($query, $binds, $this->db);
			$lastid = jqGridDB::lastInsertId($this->db, $this->table, 'event_id', $this->dbtype);
			jqGridDB::commit($this->db);
			jqGridDB::closeCursor($this->dbtype == "adodb" ? $ado : $query);
			return $lastid;
		} else {
			return false;
		}
	}

	public function editEvent( $data=array() )
			//$id, $start, $end, $title, $description, $location, $categories, $access, $allDay)
	{
		if (!empty($this->user_id) && !empty($this->table)) {
			if(!isset($data['user_id'])) { return false; }
			if(is_array($this->user_id)) {
				if(!in_array($data['user_id'], $this->user_id)) { return false;}
			} else {
				if($data['user_id'] != $this->user_id) { return false; }
			}

			$tableFields = array_keys($this->dbmap);
			$rowFields = array_intersect($tableFields, array_keys($data));
			$binds = array();
			$updateFields = array();
			$pk = 'event_id';
			foreach($rowFields as $key => $field) {
				$value = $data[$field];
				if( strtolower($this->encoding) != 'utf-8' ) {
					$value = iconv("utf-8", $this->encoding."//TRANSLIT", $value);
				}
				if(in_array($field, array('user_id', 'start', 'end','all_day'))) {
					$value = (int)$value;
				}
				if($field != $pk ) {
					$updateFields[] = $this->qout.$field.$this->qout. " = ?";
					$binds[] = $value;
	           } else if($field == $pk) {
		            $v2 = (int)$value;
				}
			}
			if(!isset($v2)) die("Primary value is missing");
			$binds[] = $v2;
			$sql = "";
			if(count($updateFields) > 0) {
				$sql = "UPDATE ".$this->qout.$this->table.$this->qout.
					" SET ". implode(', ', $updateFields).
					" WHERE ".$this->qout.$pk.$this->qout." = ?";
				// Prepare update query
			}
			if(!$sql ) { return false; }
			$query = jqGridDB::prepare($this->db, $sql , $binds);
			$ado = jqGridDB::execute($query,  $binds, $this->db);
			jqGridDB::closeCursor($this->dbtype == "adodb" ? $ado : $query);
			return true;
		} else {
			return false;
		}
	}

	public function moveEvent($id, $start, $end, $allDay) {
		if (!empty($this->user_id) && !empty($this->table)) {
			$q = $this->qout;
                        $param = array((int)$start,
				(int)$end,
				(int)$allDay,
				(int)$id
			);
			$query = jqGridDB::prepare($this->db,
			"UPDATE ".$q.$this->table.$q." SET ".$q."start".$q."=?, ".$q."end".$q."=?, ".$q."all_day".$q."=? WHERE ".$q."event_id".$q."=?",
                                $param
                        );
			$ado = jqGridDB::execute($query, $param, $this->db );
			jqGridDB::closeCursor($this->dbtype == "adodb" ? $ado : $query);
			return  true;
		} else {
			return false;
		}
	}
  
	 public function resizeEvent($id, $start, $end) {
		if (!empty($this->user_id) && !empty($this->table)) {
			$q = $this->qout;
                        $param = array((int)$start,
				(int)$end,
				(int)$id
			);
			$query = jqGridDB::prepare($this->db,
			"UPDATE ".$q.$this->table.$q." SET ".$q."start".$q."=?, ".$q."end".$q."=? WHERE ".$q."event_id".$q."=?",
			$param );
			$ado = jqGridDB::execute($query, $param, $this->db);
			jqGridDB::closeCursor($this->dbtype == "adodb" ? $ado : $query);
			return true;
		} else {
			return false;
		}
	}

	public function removeEvent($id) {
		if (!empty($this->user_id) && !empty($this->table)) {
			$q = $this->qout;
                        $param = array((int)$id);
			$query = jqGridDB::prepare($this->db,"DELETE FROM ".$q.$this->table.$q." WHERE ".$q."event_id".$q."=?",
				$param
			);
			$ado = jqGridDB::execute($query, $param, $this->db);
			jqGridDB::closeCursor($this->dbtype == "adodb" ? $ado : $query);
			return true;
		} else {
			return false;
		}
	}
  
	public function getEvents($start, $end) {
		if (!empty($this->user_id) && !empty($this->table) ) {
			$q = $this->qout;
			$b = $q ? "'" : "";
			$sql = "SELECT ";
			$i =0;
			foreach($this->dbmap as $k=>$v) {
				$k = $q.$k.$q;
				$v = $b.$v.$b;
				$sql .= $i==0 ?  $k ." AS ".$v :  ", ".$k ." AS ".$v;
				$i++;
			}
			$sql .= ' FROM '.$q.$this->table.$q.' WHERE ';
			if($this->wherecond && strlen($this->wherecond) > 0)
			{
				$pos = stripos($this->wherecond, 'where');
				if($pos !== false) {
					$this->wherecond = substr_replace($this->wherecond,"", $pos, 5);
				}
				$sql .= $this->wherecond.' AND ';
			}
			$sqluser = "(";
			if(is_array($this->user_id)) {
				foreach($this->user_id as $k =>$v) {
					if($k != 0) {
						$sqluser .= " OR user_id = ? ";
					} else {
						$sqluser .= " user_id = ? ";
					}
				}
			} else {
				$sqluser .= " user_id = ? ";
			}
			$sqluser .= ")";
			if(strlen($this->searchwhere) > 0 ) {
				$sql .= $this->searchwhere.' AND '.$sqluser.' ORDER BY start DESC';
				$params = $this->whereparams;
				foreach($this->searchdata as $k => $v)
				{
					$params[] = $v;
				}
				//$params[]
				if(is_array($this->user_id) ) {
					foreach($this->user_id as $k =>$v) {
						$params[] = (int)$v;
					}
				} else {
					$params[] = (int)$this->user_id;
				}
			} else {
				$sql .= $sqluser.' AND start >= ? AND start <= ? ORDER BY start';
				$params = $this->whereparams;
				//$params[]
				if(is_array($this->user_id) ) {
					foreach($this->user_id as $k =>$v) {
						$params[] = (int)$v;
					}
				} else {
					$params[] = (int)$this->user_id;
				}
				$params[] = (int)$start;
				$params[] = (int)$end;
			}
			$query = jqGridDB::prepare($this->db, $sql, $params );
                        if($this->dbtype == "adodb") {
                            $query = jqGridDB::execute($query, $params, $this->db);
                        } else {
                            $ret = jqGridDB::execute($query, $params, $this->db);
                        }
			$ev = array();
			while($row = jqGridDB::fetch_assoc($query, $this->db))
			{
				$row[$this->dbmap['all_day']] = $row[$this->dbmap['all_day']] == 1 ? true : false;
				$ev[] = $row;
			}
			jqGridDB::closeCursor($query);
			return $ev;
		} else {
			return false;
		}
	}
}
?>