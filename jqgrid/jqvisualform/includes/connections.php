<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
	function parse_connection_string($connection_string)
	{
		class connection_info {
			var $host;
			var $port = "3306";
			var $database;
			var $user_id;
			var $password;
			var $charset = "utf8";
		}

		$info = new connection_info;
		$parameters = preg_split("/;/", $connection_string);
		foreach($parameters as $parameter)
		{
			if (strpos($parameter, "=") < 1) continue;
			
			$parts = preg_split("/=/", $parameter);
			$name = $parts[0];
			if (count($parts) > 1) $value = $parts[1];
			
			if (isset($value))
			{
				switch (strtolower($name))
				{
					case "server":
					case "host":
					case "location":
						$info->host = $value;
						break;

					case "port":
						$info->port = $value;
						break;

					case "database":
					case "data source":
						$info->database = $value;
						break;

					case "uid":
					case "user":
					case "user id":
						$info->user_id = $value;
						break;

					case "pwd":
					case "password":
						$info->password = $value;
						break;
						
					case "charset":
						$info->charset = $value;
						break;
				}
			}
		}

		return $info;
	}
	function pdo_test_connection($connection_string, $dbtype)
	{
		$info = parse_connection_string($connection_string);
		//$link = mysql_connect("$info->host:$info->port", $info->user_id, $info->password) or die("ServerError:Could not connect to host '$info->host'");
		try {
			//var_dump($info);
			$conn = new PDO($dbtype.':host='.$info->host.';dbname='.$info->database,$info->user_id, $info->password);
			return "success";
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

?>
