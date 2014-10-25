<?php

class CandidatureController extends BaseController {

	public function getCreateCandidature()
	{
		return View::make('pages.Candidatures.Candidatures');
	}


	public function creerCandidature()
	{

			$validator = Validator::make(Input::all(),
			array(
				'InputNom' => 'required',
				'InputPrenom' => 'required',
				'InputAnnee' => 'required|min:4|integer',
				'InputSexe' => 'required|min:1|max:1',
				'InputNatio' => 'required',
				'InputTel' => 'required|min:10',
				'InputAdr' => 'required',
				'InputCP' => 'required|min:5|integer',
				'InputDernDip' => 'required',
				'InputAnneeDernDip' => 'required|min:4|integer',
				'email' => 'required|max:50|email|unique:candidatures',));


			// Si la validation échoue, on redirige vers la même page avec les erreurs
		if($validator->fails()){
			return Redirect::route('creationCandidature-get')
					->withErrors($validator)
					->withInput();
		}else{
		
			// Mise à jour dans la base de donnnées
			$candidature = new Candidature ;

		    $candidature -> nom = Input::get('InputNom');
		    $candidature -> prenom = Input::get('InputPrenom');
		    $candidature -> annee_naissance = Input::get('InputAnnee');
		    $candidature -> sexe = Input::get('InputSexe');
		    $candidature -> nationalite = Input::get('InputNatio');
		    $candidature -> telephone = Input::get('InputTel');
		    $candidature -> adresse = Input::get('mail');
		    $candidature -> codePostal = Input::get('mail');
		    $candidature -> dernier_diplome = Input::get('mail');
		    $candidature -> annee_dernier_diplome = Input::get('mail');
		    $candidature -> email = Input::get('mail');
		
		    $candidature = Candidature::find(Auth::user()->id);

			$candidature -> Candidature::save();


			//Redirection avec message d'indication que le brouillion est crée (l'insertion en base à eu lieu
			//mais on peut encore modifier)
			return Redirect::to('creationCandidature-get')->with('message', 'Votre brouillion est enregistré');

			
		}




	}

}