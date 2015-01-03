<?php

class GestionController extends BaseController {

	// Vue de gestion des candidatures
	public function getListeCandidatures()
	{
		// Liste de toutes les candidatures sauf les brouillons
		$candidatures = DB::table('candidatures')->whereNotIn('etat_id', array(Constantes::BROUILLON))->get();

		return View::make('pages.gestion.gestionCandidatures')->with('candidatures', $candidatures);
	}
}
