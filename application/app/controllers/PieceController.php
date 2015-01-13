<?php 

class PieceController extends BaseController {

    public function getPiece(){

    	$candidature = $this->getCandidatureByUserLogged();

        return View::make('pages.Candidatures.pieces')->with(array('etat' => $candidature->etat_id,
                'commentaire' => $candidature->commentaire_gestionnaire));
    }

    // POST upload de piece jointe
	public function upload(){

		$candidature = $this->getCandidatureByUserLogged();

	    // Si l'état est validé ou à refusé, l'étudiant ne pourra plus modifié sa candidature
        if($candidature->etat_id == Constantes::ENVOYE 
                or $candidature->etat_id == Constantes::VALIDE or $candidature->etat_id == Constantes::REFUSE){
            return Redirect::route('piece-get');

         }else{

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

                    // Tous les caractères accentués du nom du fichier seront remplacés par le caractère non accentué
                    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
                    
                    $filename = strtr( $filename, $unwanted_array );

					$path = $properties['uploadsPath'];

					// code de fichier
					$code = str_random(15);

					$uid = Auth::user()->id.'-'.$code.'-'.$filename;

					$file->move($path, $uid);
					$fileModel = new Piece;
					$fileModel->uid = $uid;
					$fileModel->filename = $filename;

	                $candidature_id = $this->getCandidatureByUserLogged()->id; 

					$fileModel->candidature_id = $candidature->id;
					$fileModel->save();
				}
			}

         }
	}

    // Suppression de la pièce jointe
    public function deletePj($id){

    	if($id != null){

    		$piece = Piece::where('id', '=', $id);

    		if($piece->count()){
    			$piece = $piece->first();

    			$candidature = Candidature::where('id', "=", $piece->candidature_id);
    			if($candidature->count()){
    				$candidature = $candidature->first();

    					if(Auth::user()->id == $candidature->utilisateur_id){

                            $properties = parse_ini_file("properties.ini");
                            $path = $properties['uploadsPath'];

    						File::delete($path.$piece->uid);
    						DB::table('pieces')->where('id', '=', $id)->delete();
    					}else{
    						App::abort(403, 'Unauthorized action.');
    					}
    				}
    			}
    		}
    	}

    // Liste des pièces jointes
    public function showPjs(){

    	$candidature = $this->getCandidatureByUserLogged();
        $candidature_id = $candidature->id;

    	$fichiers = DB::table('pieces')->where('candidature_id', $candidature_id)->get();
    	return View::make('pages.Candidatures.pjs')->with(array('pjs' => $fichiers, 'etat' => $candidature->etat_id));
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

    public function download(){

        $file= public_path(). "/download/info.pdf";
        $headers = array(
              'Content-Type: application/pdf',
            );
        return Response::download($file, 'filename.pdf', $headers);
    }

}
