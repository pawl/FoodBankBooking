<?php                                                                                
 
 include "addContact.php";
 
	function GetContact($number,$name)
	{
		$url = "https://api.sendhub.com/v1/contacts/?username=8177398992&api_key=47c1bc2277dded0d429e275f583e3564e50da350";
		 
		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                                                                                     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		 
		$result = curl_exec($ch);
		$json = json_decode($result);
		//echo $json->{"objects"};
		foreach ($json->{"objects"} as $obj)
		{
			$testNumb = str_replace("+1","",$obj->{"number"});
			$givenNumb = str_replace("+1","",$number);
			if ($testNumb == $givenNumb)
				return $obj->{"id"};
		}
		return CreateContact($name, $number);
	}

?>