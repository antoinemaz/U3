<?php 

class DiplomeController extends BaseController {

    public function __construct()
    {
    }


    public function getDiplome(){

        $candidature = $this->getCandidatureByUserLogged();
    	$candidature_id = $candidature -> id;
        $candidature_etat = $candidature -> etat_id;
        $candidature_commentaire = $candidature-> commentaire_gestionnaire;

        // On récupère tous les diplomes liés à la candidature (6 au max)
    	$diplomes = DB::table('diplomes')->where('candidature_id', $candidature_id)->get();

    	return View::make('pages.Candidatures.diplomes')->with(array('diplomes' => $diplomes, 'etat' => $candidature_etat,
            'commentaire' => $candidature_commentaire ));
    }

    public function postDiplome($idCandidature = null){
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
                 return Redirect::route('diplome-get');

             }else{

                 // VALIDATOR COTE SERVEUR : cas particulier car on traite des tableaux d'input 

                // ANNEE VALIDATOR
                foreach (Input::get('annee') as $anneeInput) {

                   $validator = Validator::make(
                        array('annee' => $anneeInput),
                        array('annee' => array('numeric', 'regex:/[0-9]{4}/'))
                        );

                        if($validator->fails()){
                        return Redirect::route('diplome-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }

                // ETABLISSEMENT VALIDATOR
                foreach (Input::get('etablissement') as $etablissementInput) {

                   $validator = Validator::make(
                        array('etablissement' => $etablissementInput),
                        array('etablissement' => array('max:100'))
                        );

                        if($validator->fails()){
                        return Redirect::route('diplome-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }

                // DIPLOME VALIDATOR
                foreach (Input::get('diplome') as $diplomeInput) {

                   $validator = Validator::make(
                        array('diplome' => $diplomeInput),
                        array('diplome' => array('max:100'))
                        );

                        if($validator->fails()){
                        return Redirect::route('diplome-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }

                // MOYENNE VALIDATOR
                foreach (Input::get('moyenne_annee') as $moyenneInput) {

                   $validator = Validator::make(
                        array('moyenne_annee' => $moyenneInput),
                        array('moyenne_annee' => array('numeric', 'min:0', 'max:20'))
                        );

                        if($validator->fails()){
                        return Redirect::route('diplome-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }

                 // ETABLISSEMENT VALIDATOR
                foreach (Input::get('mention') as $mentionInput) {

                   $validator = Validator::make(
                        array('mention' => $mentionInput),
                        array('mention' => array('max:100'))
                        );

                        if($validator->fails()){
                        return Redirect::route('diplome-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }

                // RANG VALIDATOR
                foreach (Input::get('rang') as $rangInput) {

                   $validator = Validator::make(
                        array('rang' => $rangInput),
                        array('rang' => array('max:100'))
                        );

                        if($validator->fails()){
                        return Redirect::route('diplome-get')
                        ->withErrors($validator)
                        ->withInput();
                       } 
                 }
             // FIN DU VALIDATOR COTE SERVEUR

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

                    if(Input::get('btnEnreg')){
                        return Redirect::route('diplome-get')->with('succes', 'Modifications effectuées');
                     }
                }
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

    public function getCandidatureById($idCandidature){

            $candidature = Candidature::where('id', '=', $idCandidature);

            if($candidature->count()){
                $candidature = $candidature->first();   
                return $candidature;
            }
    }

}
