<?php

class RedmineClient {

	const lien = 'http://192.168.203.129/';
	const key = '93c1772e9477c381d2ade68fb206dc157d55e813';

  public function getValues($object)
  {
		$lien = $this::lien . $object . '.json?key='.$this::key;

		// Initialisation session CURL
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $lien);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json')                                                                       
		);
		
		// On exécute la session curl avec tous les paramètres : on retourne un tableau (à partir d'une réponse JSON)
		$values = json_decode(curl_exec($curl), true);
		curl_close($curl); 
		return $values;
  }

  public function insererCandidature($candidature)
  {
		$lien = $this::lien.'issues.json?key='.$this::key;

		// set POST params
		$data = array();
		// had to create the string this way to make sure it got valid json format
		 $data['issue'] = array(
			'project_id' => 3,
			'tracker_id' => 4,
			'status_id' => 1,
			'priority_id' => 2, 
			'subject'=> $candidature->prenom,
			'author_id'=> 1,
			'lock_version'=> 0,
			'done_ratio'=> 0,
			'is_private'=> 0,
			'description' => 'AAA',
			'custom_fields'=> array( 
				array('id'=>1, 'value'=> 'MIAGE'),
				array('id'=>2, 'value'=> 'AAA'),
				//array('id'=>8, 'value'=> 0),
				array('id'=>9, 'value'=> 1991),
				array('id'=>3, 'value'=> '2014-10-27')
				//array('id'=>1, 'value'=> 'ASR'),
				/*array('id'=>18, 'name'=> 'Régime d\'inscription' ,'value'=> 'Formation initiale'),
				array('id'=>15, 'name'=> 'Pays' ,'value'=> 'France'),
				array('id'=>5, 'name'=> 'Nationalité' ,'value'=> 'Français'),
				array('id'=>4, 'name'=> 'Sexe' ,'value'=> 'masculin'),
				array('id'=>1, 'name'=> 'Filière' ,'value'=> 'MIAGE'),
				array('id'=>2, 'name'=> 'Prénom' ,'value'=> 'AAA') */
				 )); 

		//print_r($data);
	
		$jsonData = json_encode($data);

		echo $jsonData;

		// Initialisation session CURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $lien);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

		$result = curl_exec($ch);

		curl_close($ch); 
		return null;
  }

}
