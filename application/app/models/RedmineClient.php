<?php

class RedmineClient {

	const lien = 'http://192.168.203.129/';
	const login = 'admin';
	const password = 'password';

  public function getValues($object)
  {
		$lien = $this::lien . $object . '.json';

		// Initialisation session CURL
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $lien);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERPWD,  $this::login . ":" . $this::password);  
		curl_setopt($curl, CURLOPT_POST, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json')                                                                       
		);
		
		// On exécute la session curl avec tous les paramètres : on retourne un tableau (à partir d'une réponse JSON)
		$values = json_decode(curl_exec($curl), true);
		curl_close($curl); 
		return $values;
  }

  public function postValues($object)
  {
		$lien = 'http://192.168.203.129/issues.json?key=93c1772e9477c381d2ade68fb206dc157d55e813';

		// set POST params
		$data = array();
		// had to create the string this way to make sure it got valid json format
		$data['issue'] = array("project_id"=> 3, "subject"=>"aaa", "custom_fields"=> array( array("id"=>2, "name"=>"Prénom","value"=>"AAA") ));
		$data_string = json_encode($data);

		echo $data_string;

		// Initialisation session CURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $lien);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json'
		//'Content-Length: ' . strlen($data_string),
		//'Authorization: Bearer ' . '93c1772e9477c381d2ade68fb206dc157d55e813')
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

		$result = curl_exec($ch);
		curl_close($ch); 
		return $result;
  }

}
