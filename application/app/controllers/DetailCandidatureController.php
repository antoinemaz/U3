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
			'pieces' => $pieces));

	}



	public function postDetailCandidature(){

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