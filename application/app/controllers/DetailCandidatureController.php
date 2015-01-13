<?php

class DetailCandidatureController extends BaseController {

	public function getDetailCandidature($id)
	{
		$candidature = $this->getCandidatureById($id);

		// Récupération des informations pour le formulaire Candidature (premiere partie)
		$client = new RedmineClient();
		$tabFilliere = $client->getFilieres();

		// $tabFilliere = ["MIAGE","MIAGE App","ASR","Info","FC"];

		$tabRegimeInscription = $client->getRegimeInscription();
      	//$tabRegimeInscription = ["Formation initiale","Formation alternance","Formation permanente","Formation continue"];
        
        $annee_convoitee = $client->getAnneesUniversite();

/*		$annee_convoitee[2] = ('Année L2');
		$annee_convoitee[3] = 'Année L3';
		$annee_convoitee[4] = 'Année M1';
		$annee_convoitee[5] = 'Année M2';
		$annee_convoitee[6] = 'Information sur le site';*/

      	$filieresCandidature = explode("|", $candidature->filiere);

      	$listePays = new ListePays();
      	$tabPays = ListePays::getListeDesPays();
		
		$tabSexe = ["masculin", "féminin"];

		// Récupération des informations pour le formulaire Diplome (deuxième partie)
    	$diplomes = DB::table('diplomes')->where('candidature_id', $candidature->id)->get();

    	// Récupération des informations pour le formulaire Stage (troisieme partie)
    	$stages = DB::table('stages')->where('candidature_id', $candidature->id)->get();

    	// Récupération des informations pour le formulaire Pieces jointes (dernière partie)
    	$pieces = DB::table('pieces')->where('candidature_id', $candidature->id)->get();

    	// Récupération du mail de l'utilisateur
    	$emailUser = '';
    	$user = DB::table('utilisateurs')->where('id', $candidature->utilisateur_id);
    	if($user->count()){
			$user = $user->first(); 	
			$emailUser = $user->email;  
		 }

		return View::make('pages.gestion.detailCandidature')
		->with(array('candidature'=>$candidature, 
			'tabFiliere' => $tabFilliere, 
			'tabRegimeInscription' => $tabRegimeInscription,
			'filieresCandidature' => $filieresCandidature,
			'tabPays' => $tabPays,
			'annee_convoitee' => $annee_convoitee,
			'tabSexe' => $tabSexe,
			'diplomes' => $diplomes,
			'stages' => $stages,
			'pieces' => $pieces,
			'email' => $emailUser));
	}

	// Sauvegarde des informations de la candidature
	public function postDetailCandidature($id){

			// On clique sur le bouton Enregistrer coté Admin
	        if(Input::get('btnEnreg') or Input::get('btnEnregAdmin')) {

				$candidature = $this->getCandidatureById($id);

				// Si l'état est brouillon ou à revoir, le gestionnaire ne pourra plus modifié sa candidature
				if($candidature->etat_id == Constantes::BROUILLON or $candidature->etat_id == Constantes::AREVOIR
					or $candidature->etat_id == Constantes::REFUSE){
					return Redirect::route('detailCandidature-get', $candidature->id);
				}else{

					// On récupère le traitement du controlleur Candidature pour sauvegarder les infos de la candidature
					$cand = new CandidatureController();
					$cand->creerCandidature($candidature->id);

					// On récupère le traitement du controlleur Stage pour sauvegarder les infos des stages
             		$stage = new StageController();
             		$stage->postStage($candidature->id);

             		// On récupère le traitement du controlleur Diplome pour sauvegarder les infos des diplomes
             		$diplome = new DiplomeController();
             		$diplome->postDiplome($candidature->id);

				 	return Redirect::route('detailCandidature-get',$candidature->id)->with('succes', 'Modifications effectuées');
				}		
			}
		}

	// Modification de l'état de la candidature
	public function postActionCandidature($id){

		$candidature = $this->getCandidatureById($id);

		// Dans tous les cas, on modifie le commentaire du gestionnaire
		$candidature->commentaire_gestionnaire = Input::get('commentGestionnaire');

		// On va récupérer le mail de l'utilisateur de la candidature pour l'envoi du mail
		$mailUser = '';
		$user = Utilisateur::where('id', '=', $candidature->utilisateur_id);
		if($user->count()){
			$user = $user->first(); 	
			$mailUser = $user->email;
		 }

		// On clique sur le bouton Valider
	    if(Input::get('btnValide')) {

		    // Appel de la méthode qui envoie le tout dans Redmine :
		    $client = new RedmineClient();	
	    	$client->insererCandidature($candidature);

	    	// Changement de l'état de la candidature
	    	$candidature->etat_id = Constantes::VALIDE;

	    	// Suppression de certaines données de la candidature dans notre base
	    	$candidature = $this->supprimerDonneesCandidature($candidature);

		     if($candidature->save()){
		     		// Envoi d'un mail pour avertir de la validation de la candidature à l'étudiant
		     		$mailService = new MailService();
		     		$mailService->sendMailCandidatureValidee($mailUser, $candidature);

		    		return Redirect::route('detailCandidature-get',$candidature->id)->with('succes', 'Modifications effectuées');
		    	}

	    // On clique sur le bouton A revoir
	    }elseif(Input::get('btnArevoir')){

	    	$candidature->etat_id = Constantes::AREVOIR;
	    	if($candidature->save()){
    			// Envoi d'un mail pour avertir que la candidature est à revoir
	     		$mailService = new MailService();
	     		$mailService->sendMailCandidatureArevoir($mailUser, $candidature);

	    		return Redirect::route('detailCandidature-get',$candidature->id)->with('succes', 'Modifications effectuées');
	    	}

	    // On clique sur le bouton Refuser
	    }else{
	    	$candidature->etat_id = Constantes::REFUSE;

	    	// Suppression de certaines données de la candidature dans notre base
	    	$candidature = $this->supprimerDonneesCandidature($candidature);

	    	if($candidature->save()){
	    		// Envoi d'un mail pour avertir que la candidature est à refusée
	     		$mailService = new MailService();
	     		$mailService->sendMailCandidatureRefusee($mailUser, $candidature);

	    		return Redirect::route('detailCandidature-get',$candidature->id)->with('succes', 'Modifications effectuées');
	    	}
	    }

	}

	public function supprimerDonneesCandidature($candidature){
    	// Suppression de tous les diplomes en base
    	$diplomes = DB::table('diplomes')->where('candidature_id', $candidature->id)->delete();

    	// Suppression de tous les stages en base
    	$stages = DB::table('stages')->where('candidature_id', $candidature->id)->delete();

    	// Suppression de toutes les pièces jointes sur le file system
		$piecesCandidature =DB::table('pieces')->where('candidature_id', '=', $candidature->id)->get();

		foreach ($piecesCandidature as $key => $value) {
			
			if($value->uid != null){
				// Suppression du fichier dans le file system
				$properties = parse_ini_file("properties.ini");
        		$path = $properties['uploadsPath'];

				File::delete($path.$value->uid);		
				// Puis en base 
				DB::table('pieces')->where('id', '=', $value->id)->delete();		
			}
		}

		// Suppression de certaines valeurs parmis les informations élémentaires de la candidature
	     $candidature -> date_naissance = null;
	     $candidature -> lieu_naissance = null;
	     $candidature -> sexe = null;
	     $candidature -> dossier_etrange = null;
	     $candidature -> nationalite = null;
	     $candidature -> telephone = null;
	     $candidature -> adresse = null;
	     $candidature -> Ville = null;
	     $candidature -> codePostal = null;
	     $candidature -> Pays = null;
	     $candidature -> date_dernier_diplome = null;
	     $candidature -> commentaire_gestionnaire = null;

	     return $candidature;
	}

	 // Suppression de la pièce jointe
    public function deletePj($id){

    	if($id != null){

	    		$piece = Piece::where('id', '=', $id);

	    		if($piece->count()){
				$piece = $piece->first();

				if(Auth::user()->role_id == 2){

					$properties = parse_ini_file("properties.ini");
        		    $path = $properties['uploadsPath'];

					File::delete($path.$piece->uid);
					DB::table('pieces')->where('id', '=', $id)->delete();

					return Redirect::route('detailCandidature-get',$piece->candidature_id)
					->with('succes', 'Modifications effectuées');

				}else{
					App::abort(403, 'Unauthorized action.');
				}
    		}
    	}
    }

    public function getCandidatureById($id){

		 // Récupération de la candidature de l'étudiant par son id
		 $idUser = Auth::user()->id;
		 $candidature = Candidature::where('id', '=', $id);

		 if($candidature->count()){
			$candidature = $candidature->first(); 	
		 }
		 return $candidature;
	}


}