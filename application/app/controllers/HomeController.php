<?php 

class HomeController extends BaseController {

	public function index()
	{
		return View::make('pages.index');
	}

	public function upload(){

		ini_set('upload_max_filesize', '100M');
		ini_set('post_max_size', '100M');

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
				$fileModel->candidature_id = Auth::user()->id;
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

    	$fichiers = DB::table('pieces')->where('candidature_id', Auth::user()->id)->get();
    	return View::make('pages.pjs')->with('pjs', $fichiers);
    }

}
