<?php

class CandidatureController extends BaseController {

	public function getCreateCandidature()
	{
		return View::make('pages.Candidatures.Candidatures');
	}


	public function creerCandidature()
	{


		$etudiant = new Etudiant ;

		$etudiant -> nom = Input::get('nom');
		$etudiant -> mail = Input::get('mail');
		




		$etudiant -> save();

	}

}