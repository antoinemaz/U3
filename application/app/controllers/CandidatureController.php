<?php

class CandidatureController extends BaseController {

	public function getCreateCandidature()
	{
     	$candidature = $this->getCandidatureByUserLogged();

     	$client = new RedmineClient();
		$tabFilliere = $client->getFilieres();

      	/*$tabFilliere = ["MIAGE","MIAGE App","ASR","Info","FC"];*/

      	$tabRegimeInscription = $client->getRegimeInscription();

      /*	$tabRegimeInscription = ["Formation initiale","Formation alternance","Formation permanente","Formation continue"];*/
        
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

		// Récupération du mail de l'utilisateur
		$emailUser = '';
		$user = DB::table('utilisateurs')->where('id', $candidature->utilisateur_id);
		if($user->count()){
			$user = $user->first(); 	
			$emailUser = $user->email;  
		}

		return View::make('pages.Candidatures.Candidatures')
		->with(array('candidature'=>$candidature, 
			'tabFiliere' => $tabFilliere, 
			'tabRegimeInscription' => $tabRegimeInscription,
			'filieresCandidature' => $filieresCandidature,
			'tabPays' => $tabPays,
			'annee_convoitee' => $annee_convoitee,
			'tabSexe' => $tabSexe,
			'etat' => $candidature->etat_id,
			'commentaire' => $candidature->commentaire_gestionnaire,
			'email' => $emailUser));
	}



	public function creerCandidature($idCandidature = null)
	{
         // On clique sur le bouton Enregistrer
        if(Input::get('btnEnreg') or Input::get('btnEnregAdmin')) {
            if($idCandidature != null){
                $candidature = $this->getCandidatureById($idCandidature);
            }else{
                $candidature = $this->getCandidatureByUserLogged();
            }

            // Si l'état est validé ou à refusé, l'étudiant ne pourra plus modifié sa candidature
             if(Input::get('btnEnreg') and ($candidature->etat_id == Constantes::ENVOYE 
                or $candidature->etat_id == Constantes::VALIDE or $candidature->etat_id == Constantes::REFUSE)){
                 return Redirect::route('creationCandidature-get');

             }else{

				//Récupération du tableau de filiere
				$filiere = Input::get('filiere');

	        	if($filiere != null){
	        		
					$chaine = '';

					foreach ($filiere as $key => $value) {
						$chaine = $chaine . $value.'|' ;
					}

					//Suppression du dernier pipeline
					//Renvois une chaine de ce type : (scénario tout est coché) : MIAGE|MIAGE App|ASR|Info|FC
					$Finalchaine = rtrim($chaine, "|");
	        	}

			 	$validator = Validator::make(Input::all(),array(	
						'InputNom' => 'required|min:1|max:150',
						'InputPrenom' => 'required|min:1|max:150',
						'InputDateNaissance' => 'required|date_format:d/m/Y',
						'InputLieu' => 'required|min:1|max:150',
						'InputTel' => 'required|numeric|regex:/^[0-9]{8,20}$/',
						'InputAdr' => 'required|min:1|max:150',
						'InputVille' => 'required|min:1|max:150',
						'InputCP' => 'required|integer',
						'InputNatio' => 'required',
						'InputPays' => 'required',
						'filiere' =>  'required',
						'InputAnnee' => 'required',
						'InputSexe' => 'required',
						'InputDateDernDiplome' => 'required|date_format:d/m/Y'));

				 // Si la validation échoue, on redirige vers la même page avec les erreurs
				 if($validator->fails()){

				 	return Redirect::route('creationCandidature-get')
				 			->withErrors($validator)
				 			->withInput();

				 }else{
					  // Traitement de la date de naissance 
		        	 if(Input::get('InputDateNaissance') != ''){
		                    $dateNaissanceSplite = explode("/", Input::get('InputDateNaissance'));
		                    $date_naissance = $dateNaissanceSplite[2].'-'.$dateNaissanceSplite[1].'-'.$dateNaissanceSplite[0];
		              }else{
		                        $date_naissance = null;
		                    }

		              // Traitement de la date du dernier diplome
		              if(Input::get('InputDateDernDiplome') != ''){
		                    $dateDiplomeSplite = explode("/", Input::get('InputDateDernDiplome'));
		                    $date_diplome = $dateDiplomeSplite[2].'-'.$dateDiplomeSplite[1].'-'.$dateDiplomeSplite[0];
		              }else{
		                    $date_naissance = null;
		               }

					 $candidature -> nom = Input::get('InputNom');
					 $candidature -> prenom = Input::get('InputPrenom');
				     $candidature -> date_naissance = $date_naissance;
				     $candidature -> lieu_naissance = Input::get('InputLieu');
				     $candidature -> regime_inscription = Input::get('InputRegime');
				     $candidature -> sexe = Input::get('InputSexe');
				     $candidature -> dossier_etrange = Input::get('InputDossierE');
				     $candidature -> nationalite = Input::get('InputNatio');
				     $candidature -> telephone = Input::get('InputTel');
				     $candidature -> adresse = Input::get('InputAdr');
				     $candidature -> Ville = Input::get('InputVille');
				     $candidature -> codePostal = Input::get('InputCP');
				     $candidature -> Pays = Input::get('InputPays');
				     $candidature -> date_dernier_diplome = $date_diplome;
				     $candidature -> annee_convoitee = Input::get('InputAnnee');
				     $candidature -> save = 1;

					     if($filiere != null){
					     	 $candidature -> filiere = $Finalchaine;	
					     }

			             if($candidature->save()){
			             	if(Input::get('btnEnreg')){
							 	return Redirect::route('creationCandidature-get')->with('succes', 'Modifications effectuées');
					     	}
					     }
				}
					
			}

        }else{
        	return Redirect::route('diplome-get');
        }
	}

	public function getFinalisation(){

		$candidature = $this->getCandidatureByUserLogged();

		 // Si on est a brouillon ou a revoir, on affiche la page de finalisation de la candidature		
         if($candidature->etat_id != Constantes::BROUILLON and $candidature->etat_id != Constantes::AREVOIR){
         	 return Redirect::route('creationCandidature-get');
         }else{
         	return View::make('pages.Candidatures.finalisation')->with(array('candidature' => $candidature,
				'etat' => $candidature->etat_id,'commentaire' => $candidature->commentaire_gestionnaire));
         }

	}

	public function postFinalisation(){
		$candidature = $this->getCandidatureByUserLogged();

		// Si on est a brouillon ou a revoir, on permet la finalisation de la candidature	
		if($candidature->etat_id == Constantes::BROUILLON and $candidature->etat_id == Constantes::AREVOIR){
         	 return Redirect::route('creationCandidature-get');
         }else{
	        $candidature -> etat_id = Constantes::ENVOYE;
	        if($candidature->save()){

	        	// Envoi d'un mail selon la valeur dans configs
	        	$config = new ConfigurationController();
	        	if ($config->getValueOfConfiguration()->active == 1){
	        		// TODO : SEND MAIL AUX GESTIONNAIRES
	        	}	

			 	return Redirect::route('finalisation-get');
	    	}
         }
	}

    public function getCandidatureByUserLogged(){

		 // Récupération de la candidature de l'étudiant connecté 
		 $idUser = Auth::user()->id;
		 $candidature = Candidature::where('utilisateur_id', '=', $idUser);

		 if($candidature->count()){
			$candidature = $candidature->first(); 	
		 }
		 return $candidature;
	}

    public function getCandidatureById($idCandidature){

            $candidature = Candidature::where('id', '=', $idCandidature);

            if($candidature->count()){
                $candidature = $candidature->first();   
                return $candidature;
            }
    }

}