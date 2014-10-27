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

        
		return View::make('pages.Candidatures.Candidatures')->with(array('candidature'=>$candidature, 'tabFiliere' => $tabFilliere));
	}



	public function creerCandidature()
	{

        if(Input::get('btnEnreg')) {

            $this->candidatureDansBdd();

    //         if($candidature->save()){
			// 	return Redirect::route('creationCandidature-get')->with('message', 'Votre brouillion est enregistré');
			// }

        } elseif(Input::get('btnValid')) {

            $this->candidatureDansBdd();

   //          if($candidature->save()){
			// 	return Redirect::route('creationCandidature-get')->with('message', 'Votre candidature est validée.');
			// }
        }


	}


	public function candidatureDansBdd()
	{

			$filiere = Input::get('filiere');
			$chaine = '';

			//print_r($filiere);

			foreach ($filiere as $key => $value) {
		

				$chaine = $chaine . $value.'|' ;

			}

			//Suppression du dernier pipeline
			$Finalchaine = rtrim($chaine, "|");

			//Renvois une chaine de ce type : (scénario tout est coché) : MIAGE|MIAGE App|ASR|Info|FC

			



		// 	$validator = Validator::make(Input::all(),
		// 	array(
		// 		'InputNom' => 'required',
		// 		'InputPrenom' => 'required',
		// 		'InputAnnee' => 'required|min:4|integer',
		// 		'InputSexe' => 'required|min:1|max:1',
		// 		'InputNatio' => 'required',
		// 		'InputTel' => 'required|min:10',
		// 		'InputAdr' => 'required',
		// 		'InputVille' => 'required',
		// 		'InputCP' => 'required|min:5|integer',
		// 		'InputDernDip' => 'required',
		// 		'InputAnneeDernDip' => 'required|min:4|integer',));


		// 	// Si la validation échoue, on redirige vers la même page avec les erreurs
		// if($validator->fails()){
		// 	return Redirect::route('creationCandidature-get')
		// 			->withErrors($validator)
		// 			->withInput();
		// }else{


		// 	//Récupération de l'id de l'utilisateur courant
		// 	$idUser = Auth::user()->id;
		// 	//Récupération de la candidature de l'utilisateur courant
		// 	$candidature = Candidature::where('utilisateur_id', '=', $idUser);


		// 	//On regarde si il y a des occurences dans le résultats
		// 	if($candidature->count()){
		// 		$candidature = $candidature->first();
			

		//     $candidature -> nom = Input::get('InputNom');
		//     $candidature -> prenom = Input::get('InputPrenom');
		//     $candidature -> annee_naissance = Input::get('InputAnnee');
		//     $candidature -> sexe = Input::get('InputSexe');
		//     $candidature -> nationalite = Input::get('InputNatio');
		//     $candidature -> telephone = Input::get('InputTel');
		//     $candidature -> adresse = Input::get('InputAdr');
		//     $candidature -> Ville = Input::get('InputVille');
		//     $candidature -> codePostal = Input::get('InputCP');
		//     $candidature -> dernier_diplome = Input::get('InputDernDip');
		//     $candidature -> annee_dernier_diplome = Input::get('InputAnneeDernDip');

		//     }
			
		// }


	}


}