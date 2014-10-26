<?php

class RedmineClient {

	 var $lien;
	 var $key;

	 function __construct() {
        
	 	$properties = parse_ini_file("properties.ini");

	 	$this->lien = $properties['hote_redmine'];
	 	$this->key = $properties['token_redmine'];
    }

	// Obtention des filières en utilisant les Web service de Redmine
	public function getFilieres(){

		// On récupère la réponse du web service concernant les custom fields sous forme de tableau
		$fields = $this->getValues('custom_fields');

		// Depuis la réponse, on veut récupérer la valeur de custom fields qui contient un tableau de 
		// tous les custom fields
		$fields = $fields['custom_fields'];

		// De ce tableau de custom fields, on veut seulement récupérer la première occurence
		// car elle concerne les filières
		$filieres = $fields[0];

		// On retourne, sous forme d'un tableau, chaque filière
		return $filieres['possible_values'];
	}

	// Même principe que la méthode getFilieres()
	public function getRegimeInscription(){
		$fields = $this->getValues('custom_fields');
		$fields = $fields['custom_fields'];
		$filieres = $fields[17];
		return $filieres['possible_values'];
	}

	// Obtention des années (L3, M1...). Attention, ce n'est pas un custom field, cela correspond à des "projects" sous Redmine
	public function getAnneesUniversite(){
    	$fields = $this->getValues('projects');
    	
    	// Récupération de toutes les années
    	$fields = $fields['projects'];
	
		$annees;
    	
    	// Construction d'un tableau avec comme clé l'id de l'année et pour valeur le libellé de l'année
    	foreach ($fields as $key => $value) {
    		$annees[$value['id']] = $value['name'];
    	}
    	return $annees;
    }

  public function getValues($object)
  {
		$lienRedmine = $this->lien . $object . '.json?key='.$this->key;

		// Initialisation session CURL
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $lienRedmine);
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
		$lienRedmine = $this->lien.'issues.json?key='.$this->key;

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
			curl_setopt($ch, CURLOPT_URL, $lienRedmine);
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
