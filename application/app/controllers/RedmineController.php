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

		// On récupère la réponse du web service concernant les custom fields sous forme de tableau
		$fields = $client->getValues('custom_fields');

		// Depuis la réponse, on veut récupérer la valeur de custom fields qui contient un tableau de 
		// tous les custom fields
		$fields = $fields['custom_fields'];

		// De ce tableau de custom fields, on veut seulement récupérer la première occurence
		// car elle concerne les filières
		$filieres = $fields[0];

		// On retourne, sous forme d'un tableau, chaque filière
		return $filieres['possible_values'];
	}
}
