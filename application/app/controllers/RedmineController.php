<?php

class RedmineController extends BaseController {

	public function pushCandidatureToRedmine($id){
		if($id != null){

			// Récupération d'une candidature à partir de son id
    		$candidature = Candidature::where('id', '=', $id);

			if($candidature->count()){
    			$candidature = $candidature->first();

    			$client = new RedmineClient();	
    			$client->insererCandidature($candidature);
    		}	

    	}
	}

	// Obtention des filières en utilisant les Web service de Redmine
	public function getFilieres(){

		$client = new RedmineClient();
		return $client->uploadFile();

	}
}
