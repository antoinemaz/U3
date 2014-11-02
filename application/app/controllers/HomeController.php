<?php 

class HomeController extends BaseController {

	public function index()
	{
		// Session::put('candidature_id', $this->getCandidatureByUserLogged()->id);
		return View::make('pages.index');
	}

/*    public function getDownload(){
        //PDF file is stored under project/public/download/info.pdf
        $file= 'uploads/2-HykGsrmqIjVGAhm-RESTenPratique.pdf';
        $headers = array(
              'Content-Type: application/pdf',
            );
        return Response::download($file, 'filename.pdf', $headers);
    }*/

	public function upload(){

		$properties = parse_ini_file("properties.ini");
	
		ini_set('upload_max_filesize', $properties['sizeMaxUploadFile'].'M');
		ini_set('post_max_size', $properties['sizeMaxUploadFile'].'M');

		if(Request::ajax()){

    		$validator = Validator::make(Input::all(),
			array('file' => 'required|max:10000|mimes:pdf'));
	
			// Si la validation échoue, on redirige vers la même page avec les erreurs
			if($validator->fails()){
				// REDIRIGER VERS PAGE CANDIDATURE AVEC MESSAGE D'ERREUR
			}else{
			    $file = Input::file('file');
				$filename = $file->getClientOriginalName();
				$path = 'uploads';

				// code de fichier
				$code = str_random(15);

				$uid = Auth::user()->id.'-'.$code.'-'.$filename;

				$file->move($path, $uid);
				$fileModel = new Piece;
				$fileModel->uid = $uid;
				$fileModel->filename = $filename;

                $candidature_id = $this->getCandidatureByUserLogged()->id; 

				$fileModel->candidature_id = $candidature_id;
				$fileModel->save();
			}
		}
	}

    public function deletePj($id){

    	if($id != null){

    		$piece = Piece::where('id', '=', $id);

    		if($piece->count()){
    			$piece = $piece->first();

    			$candidature = Candidature::where('id', "=", $piece->candidature_id);
    			if($candidature->count()){
    				$candidature = $candidature->first();

    					if(Auth::user()->id == $candidature->utilisateur_id){
    						File::delete('uploads/'.$piece->uid);
    						DB::table('pieces')->where('id', '=', $id)->delete();
    					}else{
    						App::abort(403, 'Unauthorized action.');
    					}
    				}
    			}
    		}
    	}

    public function showPjs(){

        $candidature_id = $this->getCandidatureByUserLogged()->id;

    	$fichiers = DB::table('pieces')->where('candidature_id', $candidature_id)->get();
    	return View::make('pages.pjs')->with('pjs', $fichiers);
    }

    public function getDiplome(){

        // Test de diplomes et stages
    	$candidature_id = $this->getCandidatureByUserLogged()->id; 
    	$diplomes = DB::table('diplomes')->where('candidature_id', $candidature_id)->get();
        $stages = DB::table('stages')->where('candidature_id', $candidature_id)->get();

        // Test de PJs
        $candidature_id = $this->getCandidatureByUserLogged();
        $pieces = DB::table('pieces')->where('candidature_id', $candidature_id->id)->get();

    	return View::make('pages.test')->with(array(
    		'diplomes' => $diplomes, 'stages' => $stages, 'pieces' => $pieces));
    }

    public function testDiplome(){

    	$candidature_id = $this->getCandidatureByUserLogged()->id; 

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

    		return Redirect::route('diplome-get');
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
