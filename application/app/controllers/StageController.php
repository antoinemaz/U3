<?php 

class StageController extends BaseController {

    public function getStage(){

        $candidature = $this->getCandidatureByUserLogged();
        $candidature_id = $candidature -> id;
        $candidature_etat = $candidature -> etat_id;

        $stages = DB::table('stages')->where('candidature_id', $candidature_id)->get();

    	return View::make('pages.Candidatures.stages')->with(array('stages' => $stages, 'etat' => $candidature_etat));
    }

    public function postStage(){

         // On clique sur le bouton Enregistrer
        if(Input::get('btnEnreg')) {

            $candidature = $this->getCandidatureByUserLogged();

            // Si l'état est validé ou à refusé, l'étudiant ne pourra plus modifié sa candidature
             if($candidature->etat_id == 2 or $candidature->etat_id == 3){
                 return Redirect::route('stage-get');

             }else{

                 // VALIDATOR COTE SERVEUR : cas particulier car on traite des tableaux d'input 

                // DATE DEBUT VALIDATOR
                foreach (Input::get('date_debut') as $dateDebutInput) {

                   $validator = Validator::make(
                        array('date_debut' => $dateDebutInput),
                        array('date_debut' => array('date_format:d/m/Y'))
                        );

                        if($validator->fails()){
                        return Redirect::route('stage-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }

                // DATE FIN VALIDATOR
                foreach (Input::get('date_fin') as $dateFinInput) {

                   $validator = Validator::make(
                        array('date_fin' => $dateFinInput),
                        array('date_fin' => array('date_format:d/m/Y'))
                        );

                        if($validator->fails()){
                        return Redirect::route('stage-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }

                // NOM ENTREPRISE VALIDATOR
                foreach (Input::get('nom') as $nomInput) {

                   $validator = Validator::make(
                        array('nom' => $nomInput),
                        array('nom' => array('max:100'))
                        );

                        if($validator->fails()){
                        return Redirect::route('stage-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }

                // ADRESSE ENTREPRISE VALIDATOR
                foreach (Input::get('adresse') as $adresseInput) {

                   $validator = Validator::make(
                        array('adresse' => $adresseInput),
                        array('nom' => array('max:100'))
                        );

                        if($validator->fails()){
                        return Redirect::route('stage-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }

                 // TRAVAIL EFFECTUE VALIDATOR
                foreach (Input::get('travail_effectue') as $taffInput) {

                   $validator = Validator::make(
                        array('travail_effectue' => $taffInput),
                        array('travail_effectue' => array('max:400'))
                        );

                        if($validator->fails()){
                        return Redirect::route('stage-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }
             // FIN DU VALIDATOR COTE SERVEUR
                  
                  $candidature_id = $candidature->id;

                  foreach (Input::get('date_debut') as $key => $value) {   

                    if($value != ''){
                        $dateDebutSplite = explode("/", $value);
                        $datePersisteDebut = $dateDebutSplite[2].'-'.$dateDebutSplite[1].'-'.$dateDebutSplite[0];
                    }else{
                        $datePersisteDebut = null;
                    }

                    $stage = Stage::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);

                    if($stage->count()){
                        $stage = $stage->first();
                        $stage->date_debut = $datePersisteDebut;
                        $stage->save();
                    }
                  }

                 foreach (Input::get('date_fin') as $key => $value) { 
                    
                    if($value != ''){
                        $dateFinSplite = explode("/", $value);
                        $datePersisteFin = $dateFinSplite[2].'-'.$dateFinSplite[1].'-'.$dateFinSplite[0];
                    }else{
                        $datePersisteFin = null;
                    }

                    $stage = Stage::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($stage->count()){
                        $stage = $stage->first();
                        $stage->date_fin = $datePersisteFin;
                        $stage->save();
                    }
                }

                foreach (Input::get('nom') as $key => $value) {      
                    $stage = Stage::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($stage->count()){
                        $stage = $stage->first();
                        $stage->nom = $value;
                        $stage->save();
                    }
                }

                foreach (Input::get('adresse') as $key => $value) {      
                    $stage = Stage::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($stage->count()){
                        $stage = $stage->first();
                        $stage->adresse = $value;
                        $stage->save();
                    }
                }

                 foreach (Input::get('travail_effectue') as $key => $value) {      
                    $stage = Stage::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($stage->count()){
                        $stage = $stage->first();
                        $stage->travail_effectue = $value;
                        $stage->save();
                    }
                }

                return Redirect::route('stage-get')->with('succes', 'Modifications effectuées');
             }

        }elseif(Input::get('btnPrecedent')){
            return Redirect::route('diplome-get');
        }else{
            return Redirect::route('piece-get');
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
