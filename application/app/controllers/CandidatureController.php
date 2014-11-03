<?php

class CandidatureController extends BaseController {

	public function getCreateCandidature()
	{

	  $idUser = Auth::user()->id;
      $candidature = Candidature::where('utilisateur_id', '=', $idUser);

      if($candidature->count()){
      	$candidature = $candidature->first(); 	
      }


      	$tabFilliere = ["MIAGE","MIAGE App","ASR","Info","FC"];
      	$tabRegimeInscription = ["Formation initiale","Formation alternance","Formation permanente","Formation continue"];
      	$tabannee_convoitee = '{"2":"Ann\u00e9e L2","3":"Ann\u00e9e L3","4":"Ann\u00e9e M1","5":"Ann\u00e9e M2","6":"Information sur le site"}'; 
        
		return View::make('pages.Candidatures.Candidatures')->with(array('candidature'=>$candidature, 'tabFiliere' => $tabFilliere, 'tabRegimeInscription' => $tabRegimeInscription));
	}



	public function creerCandidature()
	{

        if(Input::get('btnEnreg')) {

            $this->candidatureDansBdd();

            if($candidature->save()){
			 	return Redirect::route('creationCandidature-get')->with('message', 'Votre brouillion est enregistré');
		    }

        } elseif(Input::get('btnValid')) {

           $lacandidature = $this-> candidatureDansBdd();

           $lacandidature -> etat_id = 2;

           if($lacandidature->save()){
			 	return Redirect::route('creationCandidature-get')->with('message', 'Votre candidature est validée.');
		   }
        }


	}

	public function candidatureDansBdd()
	{

			//Récupération du tableau de filiere
			$filiere = Input::get('filiere');
			$chaine = '';

			//print_r($filiere);

			foreach ($filiere as $key => $value) {
		

				$chaine = $chaine . $value.'|' ;

			}

			//Suppression du dernier pipeline
			//Renvois une chaine de ce type : (scénario tout est coché) : MIAGE|MIAGE App|ASR|Info|FC
			$Finalchaine = rtrim($chaine, "|");
	
		 	$validator = Validator::make(Input::all(),
		 	array(
		 		
					'InputNom' => 'required',
					'InputPrenom' => 'required',
					'InputDateNaissance' => 'required|min:4',
					'InputLieu' => 'required',
					'InputTel' => 'required|min:10',
					'InputAdr' => 'required',
					'InputVille' => 'required',
					'InputCP' => 'required|min:5|integer',
					'InputDateDernDiplome' => 'required|min:4',));


		 // Si la validation échoue, on redirige vers la même page avec les erreurs
		 if($validator->fails()){
		 	return Redirect::route('creationCandidature-get')
		 			->withErrors($validator)
		 			->withInput();
		 }else{


		 	//Récupération de l'id de l'utilisateur courant
		 	$idUser = Auth::user()->id;
		 	//Récupération de la candidature de l'utilisateur courant
		 	$candidature = Candidature::where('utilisateur_id', '=', $idUser);


		 	//On regarde si il y a des occurences dans le résultats
		 	if($candidature->count()){
		 		$candidature = $candidature->first();

			 $candidature -> nom = Input::get('InputNom');
			 $candidature -> prenom = Input::get('InputPrenom');
		     $candidature -> date_naissance = Input::get('InputDateNaissance');
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
		     $candidature -> filiere = $Finalchaine;
		     $candidature -> date_dernier_diplome = Input::get('InputDateDernDiplome');

		      
		     }
			
		 }

		 return $candidature;

	}


}