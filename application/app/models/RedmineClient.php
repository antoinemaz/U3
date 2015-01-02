<?php

header('Content-type: text/plain; charset=utf-8');

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
		$fields = $fields[0];

		// On retourne, sous forme d'un tableau, chaque filière
		$fields = $fields['possible_values'];

		// On va construire un tableau de filière
		$filieres = array();

		foreach ($fields as $key => $value) {
			array_push($filieres, $value['value'] );
		}

		return $filieres;

	}

	// Même principe que la méthode getFilieres()
	public function getRegimeInscription(){
		$fields = $this->getValues('custom_fields');
		$fields = $fields['custom_fields'];
		$fields = $fields[17];
		
		$fields = $fields['possible_values'];

		$regimes = array();

		foreach ($fields as $key => $value) {
			array_push($regimes, $value['value'] );
		}

		return $regimes;
	}

	// Obtention des années (L3, M1...). Attention, ce n'est pas un custom field, cela correspond à des "projects" sous Redmine
	public function getAnneesUniversite(){
    	$fields = $this->getValues('projects');
    	
    	// Récupération de toutes les années
    	$fields = $fields['projects'];
    	
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

  public function uploadFile($pjs){

  		// Initiation du tableau de PJs qui sera envoyé à Redmine via le web service
		$lesPieces = array();

		$lienRedmine = $this->lien.'uploads.json?key='.$this->key;

		foreach ($pjs as $key => $value) {
		 	// Obtention du fichier parcouru
			$contents = File::get('uploads/'.$value->uid);

			// Initialisation session CURL
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $lienRedmine);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/octet-stream'
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $contents);

			$result = curl_exec($ch);

			// on y extrait le token id du fichier
			$resultToken = json_decode($result, true);
			$resultToken = $resultToken['upload'];
			$resultToken = $resultToken['token'];

			array_push($lesPieces, 
				array('token'=> $resultToken, 
					'filename' => $value->filename,
					'description' => $value->filename, 
					'content_type' => $this->get_file_extension($value->filename)
					) 
			);
		}

		curl_close($ch); 

		return $lesPieces;
  }

  // Obtention de l'extension d'un nom d'un fichier
  function get_file_extension($file_name) {
	return substr(strrchr($file_name,'.'),1);
  }

  // Formatage des diplomes à envoyer sous forme de texte à Redmine
  function getDiplomesFormates($diplomes){

  	$chaineDiplomes = '';

  	foreach ($diplomes as $key => $value) {

  		$chaineDiplomes = $chaineDiplomes . ' BAC +'. ($value->numero-1) .')';
		$chaineDiplomes = $chaineDiplomes . ' Année : '. ($value->annee).' / ';
		$chaineDiplomes = $chaineDiplomes . ' Etablissement : '. ($value->etablissement).' / ';
		$chaineDiplomes = $chaineDiplomes . ' Moyenne année : '. ($value->moyenne_annee).' / ';
		$chaineDiplomes = $chaineDiplomes . ' Mention : '. ($value->mention).' / ';
		$chaineDiplomes = $chaineDiplomes . ' Rang : '. ($value->rang). "\r\n \r\n";
  	}
  	return $chaineDiplomes;
  }

  	// Formatage des stages à envoyer sous forme de texte à Redmine
    function getStagesFormates($stages){

  	$chaineStages = '';

  	foreach ($stages as $key => $value) {

  		$chaineStages = $chaineStages . $value->numero .')';
		$chaineStages = $chaineStages . ' Date de début : '. ($this->getDateFormate($value->date_debut)) .' / ';
		$chaineStages = $chaineStages . ' Date de fin : '. ($this->getDateFormate($value->date_fin)) .' / ';
		$chaineStages = $chaineStages . ' Nom : '. ($value->nom).' / ';
		$chaineStages = $chaineStages . ' Adresse : '. ($value->adresse).' / ';
		$chaineStages = $chaineStages . ' Travail effectué : '. ($value->travail_effectue). "\r\n \r\n";
  	}
  	return $chaineStages;
  }

  // Formatage de la date en FR
  public function getDateFormate($date){

  		if($date != null){
  		 $dateAformater = explode("-", $date);

  		 $annee = $dateAformater[0];
  		 $mois =  $dateAformater[1];
  		 $jour = $dateAformater[2];

         $newDate =  $jour . '/' . $mois  . '/' . $annee ;

         return $newDate;
  		}else{
  			return null;
  		}

  }

  // Insertion de la candidature dans Redmine
  public function insererCandidature($candidature)
  {
		$lienRedmine = $this->lien.'issues.json?key='.$this->key;

		$user = Utilisateur::where('id', '=', $candidature->utilisateur_id);
		
		if($user->count()){

			$user = $user->first();

			// création d'un tableau de filières demandées par l'étudiant
			$filieres = explode("|", $candidature->filiere);

			// gestion ds pièces jointes
			$listeNomsPieces = DB::table('pieces')->where('candidature_id', $candidature->id)->get();
			// upload des pjs et obtention du tableau a passé a l'issue
			$listOfPjs = $this->uploadFile($listeNomsPieces);

			// obtention des diplomes formatés et à envoyer:
			$diplomesEnBase = DB::table('diplomes')->where('candidature_id', $candidature->id)->get();
			$listOfDiplomes = $this->getDiplomesFormates($diplomesEnBase);

			// obtention des stages formatés et à envoyer:
			$stagesEnBase = DB::table('stages')->where('candidature_id', $candidature->id)->get();
			$listOfStages = $this->getStagesFormates($stagesEnBase);

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
				array('id'=>1, 'value'=> $filieres),
				array('id'=>2, 'value'=> $candidature->prenom),
				array('id'=>3, 'value'=> $candidature->date_naissance),
				// VALEUR EN DUR CAR DOIT ETRE SUPPRIMEE : DATE DE NAISSANCE
				array('id'=>9, 'value'=> 1991),
				array('id'=>4,'value'=> $candidature->sexe),
				array('id'=>5,'value'=> $candidature->nationalite),
				array('id'=>8, 'value'=> $candidature->dossier_etrange),
				array('id'=>10, 'value'=> $user->email),
				array('id'=>11, 'value'=> $candidature->telephone),
				array('id'=>12, 'value'=> $candidature->adresse),
				array('id'=>13, 'value'=> $candidature->ville),
				array('id'=>14, 'value'=> $candidature->codePostal),
				array('id'=>15, 'value'=> $candidature->pays),
				// DERNIER DIPLME A SUPPRIMER
				/*array('id'=>16, 'value'=> $candidature->dernier_diplome),*/
				array('id'=>18, 'value'=> $candidature->regime_inscription),
				// DATE DERNIER DIPLOME ?
				/*array('id'=>19, 'value'=> $candidature->date_dernier_diplome)*/
				array('id'=>20, 'value'=> $listOfDiplomes),
				array('id'=>21, 'value'=> $listOfStages)
				 ),
				'uploads' => $listOfPjs);
		
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
