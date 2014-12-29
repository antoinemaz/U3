<?php

class DetailCandidatureController extends BaseController {

	public function getDetailCandidature($id)
	{
		$candidature = $this->getCandidatureById($id);

		// Récupération des informations pour le formulaire Candidature (premiere partie)
		$tabFilliere = ["MIAGE","MIAGE App","ASR","Info","FC"];
      	$tabRegimeInscription = ["Formation initiale","Formation alternance","Formation permanente","Formation continue"];
        
		$annee_convoitee[2] = ('Année L2');
		$annee_convoitee[3] = 'Année L3';
		$annee_convoitee[4] = 'Année M1';
		$annee_convoitee[5] = 'Année M2';
		$annee_convoitee[6] = 'Information sur le site';

      	$filieresCandidature = explode("|", $candidature->filiere);

      	$listePays = new ListePays();
      	$tabPays = ListePays::getListeDesPays();
		
		$tabSexe = ["Masculin", "Féminin"];

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

		// On clique sur le bouton Valider
	    if(Input::get('btnValide')) {

	    //TODO : GO REDMINE !

	    // On clique sur le bouton A revoir
	    }elseif(Input::get('btnArevoir')){

	    	$candidature->etat_id = Constantes::AREVOIR;
	    	if($candidature->save()){
	    		return Redirect::route('detailCandidature-get',$candidature->id)->with('succes', 'Modifications effectuées');
	    	}

	    // On clique sur le bouton Refuser
	    }else{
	    	$candidature->etat_id = Constantes::REFUSE;
	    	if($candidature->save()){
	    		return Redirect::route('detailCandidature-get',$candidature->id)->with('succes', 'Modifications effectuées');
	    	}
	    }

	}

	 // Suppression de la pièce jointe
    public function deletePj($id){

    	if($id != null){

	    		$piece = Piece::where('id', '=', $id);

	    		if($piece->count()){
				$piece = $piece->first();

				if(Auth::user()->role_id == 2){
					File::delete('uploads/'.$piece->uid);
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