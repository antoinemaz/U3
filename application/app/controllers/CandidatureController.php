<?php

class CandidatureController extends BaseController {

	public function getCreateCandidature()
	{

     	$candidature = $this->getCandidatureByUserLogged();

      	$tabFilliere = ["MIAGE","MIAGE App","ASR","Info","FC"];
      	$tabRegimeInscription = ["Formation initiale","Formation alternance","Formation permanente","Formation continue"];
      	$tabannee_convoitee = '{"2":"Ann\u00e9e L2","3":"Ann\u00e9e L3","4":"Ann\u00e9e M1","5":"Ann\u00e9e M2","6":"Information sur le site"}'; 
        
      	$filieresCandidature = explode("|", $candidature->filiere);

		return View::make('pages.Candidatures.Candidatures')
		->with(array('candidature'=>$candidature, 
			'tabFiliere' => $tabFilliere, 
			'tabRegimeInscription' => $tabRegimeInscription,
			'filieresCandidature' => $filieresCandidature));
	}



	public function creerCandidature()
	{

		// On clique sur le bouton suivant
        if(Input::get('btnEnreg')) {

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
	
		 	$validator = Validator::make(Input::all(),array(	
					'InputNom' => 'required',
					'InputPrenom' => 'required',
					'InputDateNaissance' => 'required|min:4',
					'InputLieu' => 'required',
					'InputTel' => 'required|min:10',
					'InputAdr' => 'required',
					'InputVille' => 'required',
					'InputCP' => 'required|min:5|integer',
					'InputDateDernDiplome' => 'required|min:4'));


			 // Si la validation échoue, on redirige vers la même page avec les erreurs
			 if($validator->fails()){
			 	return Redirect::route('creationCandidature-get')
			 			->withErrors($validator)
			 			->withInput();
			 }else{
 			 		 $candidature = $this->getCandidatureByUserLogged();

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

				     if($filiere != null){
				     	 $candidature -> filiere = $Finalchaine;	
				     }

				     $candidature -> date_dernier_diplome = Input::get('InputDateDernDiplome');		

		             if($candidature->save()){
						 	return Redirect::route('diplome-get');
				     }
			}

        } elseif(Input::get('btnValid')) {

           $lacandidature = $this-> candidatureDansBdd();

           $lacandidature -> etat_id = 2;

           if($lacandidature->save()){
			 	return Redirect::route('creationCandidature-get')->with('message', 'Votre candidature est validée.');
		   }
        }


	}

	public function getFinalisation(){

		$candidature = $this->getCandidatureByUserLogged();

		return View::make('pages.Candidatures.finalisation')->with('etat', $candidature->etat_id);
	}

	public function postFinalisation(){
		$candidature = $this->getCandidatureByUserLogged();
		$candidature -> etat_id = 2;
        if($candidature->save()){
		 	return Redirect::route('finalisation-get');
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

}