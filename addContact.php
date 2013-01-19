<?php

	function CreateContact($name, $number)
	{
		$data = array("name" => $name, "number" => $number);                                                                    
		$data_string = json_encode($data);                                                                                   
		 
		$url = "https://api.sendhub.com/v1/contacts/?username=8177398992&api_key=47c1bc2277dded0d429e275f583e3564e50da350";
		 
		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		 
		$result = curl_exec($ch);
		$json = json_decode($result);
		return $json->{"id"};
	}
?>