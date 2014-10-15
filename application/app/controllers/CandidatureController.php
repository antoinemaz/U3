<?php

class CandidatureController extends BaseController {

	public function createIncident()
	{


		$etudiant = new Etudiant ;

		$etudiant -> nom = Input::get('nom');
		$etudiant -> mail = Input::get('mail');
		




		$etudiant -> save();

	}

}