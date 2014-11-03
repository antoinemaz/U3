<?php 

class StageController extends BaseController {

    public function getStage(){

        // Test de diplomes et stages
    	$candidature_id = $this->getCandidatureByUserLogged()->id; 

        $stages = DB::table('stages')->where('candidature_id', $candidature_id)->get();

    	return View::make('pages.Candidatures.stages')->with(array('stages' => $stages));
    }

    public function postStage(){

    	$candidature_id = $this->getCandidatureByUserLogged()->id;

            // Stages

            $validator = Validator::make(Input::get('date_debut'),
            array(
                'date_debut' => 'date|date_format:"d/m/Y"'));

            if($validator->fails()){
                return Redirect::route('diplome-get')
                        ->withErrors($validator)
                        ->withInput();
            }else{

                  foreach (Input::get('date_debut') as $key => $value) {   

                    if($value != ''){
                        $dateDebutSplite = explode("/", $value);
                        $datePersiste = $dateDebutSplite[2].'-'.$dateDebutSplite[1].'-'.$dateDebutSplite[0];
                    }else{
                        $datePersiste = null;
                    }

                    $stage = Stage::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);

                    if($stage->count()){
                        $stage = $stage->first();
                        $stage->date_debut = $datePersiste;
                        $stage->save();
                    }
                  }

                 foreach (Input::get('date_fin') as $key => $value) { 
                    
                    if($value != ''){
                        $dateFinSplite = explode("/", $value);
                        $datePersiste = $dateFinSplite[2].'-'.$dateFinSplite[1].'-'.$dateFinSplite[0];
                    }else{
                        $datePersiste = null;
                    }

                    $stage = Stage::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($diplome->count()){
                        $stage = $stage->first();
                        $stage->date_fin = $datePersiste;
                        $stage->save();
                    }
                }

                foreach (Input::get('nom') as $key => $value) {      
                    $diplome = Stage::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($diplome->count()){
                        $diplome = $diplome->first();
                        $diplome->nom = $value;
                        $diplome->save();
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

            }

    		return Redirect::route('stage-get');
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
