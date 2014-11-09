<?php 

class PieceController extends BaseController {

    public function getPiece(){

    	$candidature = $this->getCandidatureByUserLogged();

        return View::make('pages.Candidatures.pieces')->with('etat', $candidature->etat_id);
    }

    // POST upload de piece jointe
	public function upload(){

		$candidature = $this->getCandidatureByUserLogged();

	    // Si l'état est validé ou à refusé, l'étudiant ne pourra plus modifié sa candidature
        if($candidature->etat_id == 2 or $candidature->etat_id == 3){
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
					$path = 'uploads';

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
    						File::delete('uploads/'.$piece->uid);
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
