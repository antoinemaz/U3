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

		$user = Utilisateur::where('id', '=', $candidature->utilisateur_id);
		
		if($user->count()){
			$user = $user->first();

					// set POST params
			$data = array();
			// had to create the string this way to make sure it got valid json format
			 $data['issue'] = array(
		 	// A automatiser : correpond à l'année postulée
			'project_id' => 3,
			'tracker_id' => 4,
			'status_id' => 1,
			'priority_id' => 2, 
			'subject'=> $candidature->nom,
			'author_id'=> 1,
			'lock_version'=> 0,
			'done_ratio'=> 0,
			'is_private'=> 0,
			'custom_fields'=> array( 
				// A automatiser : PLUSIEURS POSSIBLE 
				array('id'=>1, 'value'=> 'MIAGE'),
				array('id'=>2, 'value'=> $candidature->prenom),
				// IL MANQUE DATE DE NAISSANCE
				//array('id'=>3, 'value'=> '2014-10-27'),
				// A SUPPRIME ?
				array('id'=>9, 'value'=> $candidature->annee_naissance),
				array('id'=>4,'value'=> $candidature->sexe),
				array('id'=>5,'value'=> $candidature->nationalite),
				array('id'=>8, 'value'=> $candidature->dossier_etrange),
				array('id'=>10, 'value'=> $user->email),
				array('id'=>11, 'value'=> $candidature->telephone),
				array('id'=>12, 'value'=> $candidature->adresse),
				// IL MANQUE VILLE
				//array('id'=>13, 'value'=> $candidature->ville),
				array('id'=>14, 'value'=> $candidature->codePostal),
				// IL MANQUE PAYS
				//array('id'=>15, 'value'=> $candidature->pays),
				array('id'=>16, 'value'=> $candidature->dernier_diplome),
				// IL MANQUE REGIME D'INSCRIPTION
				//array('id'=>18, value'=> 'Formation initiale'),
				array('id'=>19, 'value'=> $candidature->anee_dernier_diplome)
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
		}

		return null;
  }

}
