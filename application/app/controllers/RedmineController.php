<?php

// CLASSE DE TEST D'APPEL AU WEB SERVICE
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

		$diplomesEnBase = DB::table('stages')->where('candidature_id', 4)->get();

		$client = new RedmineClient();
		return $client->getStagesFormates($diplomesEnBase);

	}
}
