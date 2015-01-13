<?php

class GestionController extends BaseController {

	// Vue de gestion des candidatures
	public function getListeCandidatures()
	{

		// get id de l'utilisateur connecté
		$idUtilisateur = Auth::user()->id;

		// On itnitialise une variable qui contiendra toutes les candidatures filtrées
		$getListeCandidaturesTriees = array();

		// Liste de toutes les candidatures sauf les brouillons
		$candidaturesSaufBrouillon = DB::table('candidatures')->whereNotIn('etat_id', array(Constantes::BROUILLON))->get();

		// Liste  des correspondances 
		$correspondancesUser = DB::table('correspondances')->where('utilisateur_id', array($idUtilisateur))->get();

		// Parcours des correspondances du user
		foreach ($correspondancesUser as $keyCo => $valueCo) {

			// Parcours de toutes les candidatures sauf brouillon
			foreach ($candidaturesSaufBrouillon as $keyCan => $valueCan) {
					
				// Meme année, ok 
				if($valueCan->annee_convoitee == $valueCo->annee_resp){

					// Liste des filières
					$listeFilieres = explode("|", $valueCan->filiere);

					// Parcours de toutes les filières
					foreach ($listeFilieres as $keyFil => $valueFil) {
						
						if($valueCo->filiere_resp == $valueFil){
							array_push($getListeCandidaturesTriees, $valueCan);
							break;
						}
					}
				}

			}
		}

		return View::make('pages.gestion.gestionCandidatures')->with('candidatures', $getListeCandidaturesTriees);
	}
}
