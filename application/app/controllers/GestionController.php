<?php

class GestionController extends BaseController {

	// Vue de gestion des candidatures
	public function getListeCandidatures()
	{
		$candidatures = DB::table('candidatures')->get();

		return View::make('pages.gestion.gestionCandidatures')->with('candidatures', $candidatures);
	}
}
