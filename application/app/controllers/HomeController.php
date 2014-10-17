<?php 

class HomeController extends BaseController {

	public function index()
	{
		return View::make('pages.index');
	}

	public function upload(){

		if(Request::ajax())
    	{

		$file = Input::file('file');
		$filename = $file->getClientOriginalName();
		$path = 'uploads';

		// code de fichier
		$code = str_random(10);

		$file->move($path, $filename);
		$fileModel = new Piece;
		$fileModel->uid = $code."_".$filename;
		$fileModel->filename = $filename;
		$fileModel->candidature_id = Auth::user()->id;
		$fileModel->save();

		}
    }

    public function deletePj($id){

    	$file = Piece::find($id);
    	File::delete('uploads/'.$file->filename);
    	DB::table('pieces')->where('id', '=', $id)->delete();
    }

    public function showPjs(){

    	$fichiers = DB::table('pieces')->where('candidature_id', Auth::user()->id)->get();
    	//DB::table('pieces')->where('candidature_id', Auth::user()->id);
    	return View::make('pages.pjs')->with('pjs', $fichiers);
    }

}
