<?php 

class StageController extends BaseController {

    public function getStage(){

        // Test de diplomes et stages
    	$candidature_id = $this->getCandidatureByUserLogged()->id; 

        $stages = DB::table('stages')->where('candidature_id', $candidature_id)->get();

    	return View::make('pages.Candidatures.stages')->with(array('stages' => $stages));
    }

    public function postStage(){



/*        foreach ($porcentaje as $porcentaj) {
           $validator = Validator::make(
                array('porcentaje' => $porcentaj),
                array('porcentaje' => array('required','numeric','between:0,100'))
            );*/
// VOIR CUSTOM VALIDATOR


         // On clique sur le bouton suivant
        if(Input::get('btnEnreg')) {

    	   $candidature_id = $this->getCandidatureByUserLogged()->id;

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

    		return Redirect::route('piece-get');

        }else{
            return Redirect::route('diplome-get');
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
