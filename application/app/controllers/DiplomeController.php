<?php 

class DiplomeController extends BaseController {


    public function getDiplome(){


        $candidature = $this->getCandidatureByUserLogged();
    	$candidature_id = $candidature -> id;
        $candidature_etat = $candidature -> etat_id;

        // On récupère tous les diplomes liés à la candidature (6 au max)
    	$diplomes = DB::table('diplomes')->where('candidature_id', $candidature_id)->get();

    	return View::make('pages.Candidatures.diplomes')->with(array('diplomes' => $diplomes, 'etat' => $candidature_etat));
    }

    public function postDiplome(){

        // On clique sur le bouton suivant
        if(Input::get('btnEnreg')) {

            $candidature = $this->getCandidatureByUserLogged();

            // Si l'état est validé ou à refusé, l'étudiant ne pourra plus modifié sa candidature
             if($candidature->etat_id == 2 or $candidature->etat_id == 3){
                 return Redirect::route('diplome-get');

             }else{
                 
                $candidature_id = $candidature->id; 

                // Diplomes
                foreach (Input::get('annee') as $key => $value) {
                    $diplome = Diplome::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($diplome->count()){
                        $diplome = $diplome->first();
                        $diplome->annee = $value;
                        $diplome->save();
                    }
                }

                foreach (Input::get('etablissement') as $key => $value) { 
                    $diplome = Diplome::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($diplome->count()){
                        $diplome = $diplome->first();
                        $diplome->etablissement = $value;
                        $diplome->save();
                    }
                }

                 foreach (Input::get('diplome') as $key => $value) {  
                    $diplome = Diplome::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($diplome->count()){
                        $diplome = $diplome->first();
                        $diplome->diplome = $value;
                        $diplome->save();
                    }
                }

                foreach (Input::get('moyenne_annee') as $key => $value) {
                    $diplome = Diplome::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($diplome->count()){
                        $diplome = $diplome->first();
                        $diplome->moyenne_annee = $value;
                        $diplome->save();
                    }
                }

                foreach (Input::get('mention') as $key => $value) {
                    $diplome = Diplome::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($diplome->count()){
                        $diplome = $diplome->first();
                        $diplome->mention = $value;
                        $diplome->save();
                    }
                }

                foreach (Input::get('rang') as $key => $value) {      
                    $diplome = Diplome::where('candidature_id', $candidature_id)->where('numero', '=', $key+1);
                    if($diplome->count()){
                        $diplome = $diplome->first();
                        $diplome->rang = $value;
                        $diplome->save();
                    }
                }

                return Redirect::route('diplome-get')->with('succes', 'Modifications effectuées');
            }

        }elseif(Input::get('btnPrecedent')){
            return Redirect::route('creationCandidature-get');
        }else{
            return Redirect::route('stage-get');
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
