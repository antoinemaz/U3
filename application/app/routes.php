<?php

/*
|--------------------------------------------------------------------------
| Liste des routes
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get("/", array(
	'as' => 'index',
	'uses' => 'HomeController@index'));

Route::get("/redmine", array(
	'as' => 'redmine',
	'uses' => 'RedmineController@getFilieres'));

Route::get("/pushCandidatureToRedmine/{id}", array(
	'as' => 'pushCandidatureToRedmine-get',
	'uses' => 'RedmineController@pushCandidatureToRedmine'));

//////////////////////////////////////////////////////

// Ensemble des routes NON authentifiées
Route::group(array('before' => 'guest'), function(){

	// GET Page création de compte
	Route::get('compte/creer', array(
		'as' => 'creerCompte-get',
		'uses' => 'CompteController@getCreateCompte'));

	// GET Page activation du compte
	Route::get('compte/activation/{code}', array(
	'as' => 'activerCompte',
	'uses' => 'CompteController@getActivationCompte'));

	// GET Page de connexion
	Route::get('/compte/connexion', array(
		'as' => 'connexion-get',
		'uses' => 'CompteController@getConnexion'));

	// GET Page de mot de passe oublié
	Route::get('compte/password-oublie', array(
		'as' => 'password-oublie-get',
		'uses' => 'CompteController@getPasswordOublie'));

	// GET Page réinitialisation de mot de passe
	Route::get('compte/reinitialisationPassword/{code}', array(
	'as' => 'reinitialisationPassword',
	'uses' => 'CompteController@getReinitialisationPassword'));

	// Ensemble des routes de formulaire
	Route::group(array('before' => 'csrf'), function(){
		
		// POST Création de compte
		Route::post('/creerCompte', array(
			'as' => 'creerCompte-post',
			'uses' => 'CompteController@postCreateCompte'));

		// POST Connexion
		Route::post('/compte/connexion', array(
		'as' => 'connexion-post',
		'uses' => 'CompteController@postConnexion'));

		// POST Page de mot de passe oublié
		Route::post('compte/password-oublie', array(
		'as' => 'password-oublie-post',
		'uses' => 'CompteController@postPasswordOublie'));
	});
});


///////////////////////////////////////////////////////////

// Ensemble des routes authentifiées
Route::group(array('before' => 'auth'), function(){

	 // GET Création d'une candidature
	 Route::get('/candidature/creerCandidature', array(
	'as' => 'creationCandidature-get',
	'uses' => 'CandidatureController@getCreateCandidature'));	

	 // GET Déconnexion
	Route::get('/compte/deconnexion', array(
	'as' => 'deconnexion-get',
	'uses' => 'CompteController@getDeconnexion'));

	 // GET Changement de mot de passe
	Route::get('/compte/changerpassword', array(
	'as' => 'changerpassword-get',
	'uses' => 'CompteController@getChangerPassword'));

	// GET Diplome
	Route::get('/candidature/diplomes', array(
	'as' => 'diplome-get',
	'uses' => 'DiplomeController@getDiplome'));

	// GET Stage
	Route::get('/candidature/stages', array(
	'as' => 'stage-get',
	'uses' => 'StageController@getStage'));

		// GET Pieces
	Route::get('/candidature/pieces', array(
	'as' => 'piece-get',
	'uses' => 'PieceController@getPiece'));

	// Get liste des pieces jointes
	Route::get("/candidature/listePjs", array('as' => 'pjs', function(){
		if(Request::ajax()){
			return App::make('PieceController')->showPjs(); 
		}
	}));

	// GET Suppression Piece jointe
	Route::get("candidature/upload/delete/{id}", array(
	'as' => 'deletepj',
	'uses' => 'PieceController@deletePj'));

	// Download Piece jointe
	Route::get('/download', 'PieceController@download');

	// GET Finalisation
	Route::get('/candidature/finalisation', array(
	'as' => 'finalisation-get',
	'uses' => 'CandidatureController@getFinalisation'));

	// SI c'est un gestionnaire
	Route::group(array('before' => 'gestionnaire'), function() {

	    // GET Liste des candidatures
	    Route::get("/gestion/listeCandidatures", array(
			'as' => 'listeCandidatures-get',
			'uses' => 'GestionController@getListeCandidatures'));

	    // GET Détail de candidature
	    Route::get("/gestion/detailCandidature/{id}", array(
			'as' => 'detailCandidature-get',
			'uses' => 'DetailCandidatureController@getDetailCandidature'));

    	// GET Suppression Piece jointe coté gestionnaire
	 	Route::get("gestion/upload/delete/{id}", array(
		'as' => 'deletepjgestion',
		'uses' => 'DetailCandidatureController@deletePj'));

		// GET Liste des configurations
	    Route::get("/gestion/configuration", array(
			'as' => 'configuration-get',
			'uses' => 'ConfigurationController@getConfiguration'));

	    	    // GET Suppression d'un couple
	    Route::get("/gestion/coupleAnneeFilliere/delete/{id}", array(
			'as' => 'deleteCouple',
			'uses' => 'ConfigurationController@deleteCouple'));

		// Ensemble des routes de formulaire gestionnaire
		Route::group(array('before' => 'csrf'), function(){

			 // POST Détail de candidature
		    Route::post("/gestion/detailCandidature/{id}", array(
				'as' => 'detailCandidature-post',
				'uses' => 'DetailCandidatureController@postDetailCandidature'));

			 // POST Actions sur la candidature
		 	Route::post("gestion/actionCandidature/{id}", array(
			'as' => 'actionCandidature-post',
			'uses' => 'DetailCandidatureController@postActionCandidature'));

			// POST Ajout de couple Annee/Filliere au Gestionnaire courant
			Route::post('/ajouterCoupleAnneeFiliere', array(
				'as' => 'ajouterCoupleAnneeFiliere-post',
				'uses' => 'ConfigurationController@postAddCoupleAnneeFilliere'));
		});
	});

	// Ensemble des routes de formulaire
	Route::group(array('before' => 'csrf'), function(){

		 // POST Changement de mot de passe
		 Route::post('/compte/changerpassword', array(
		'as' => 'changerpassword-post',
		'uses' => 'CompteController@postChangerPassword'));

		 // POST Création de candidature
		 Route::post('/creerCandidature', array(
		'as' => 'creationCandidature-post',
		'uses' => 'CandidatureController@creerCandidature'));

		  // POST Diplomes
		 Route::post('/diplome', array(
		'as' => 'diplome-post',
		'uses' => 'DiplomeController@postDiplome'));

		 // POST Stages
		 Route::post('/stage', array(
		'as' => 'stage-post',
		'uses' => 'StageController@postStage'));

		 // POST Upload piece jointe
		 Route::post("candidature/upload", array(
		'as' => 'upload-post',
		'uses' => 'PieceController@upload'));

		 // POST Finalisation de la candidature
		 Route::post("candidature/finalisation", array(
		'as' => 'finalisation-post',
		'uses' => 'CandidatureController@postFinalisation'));
	});

	// SI c'est un administrateur
	Route::group(array('before' => 'administrateur'), function() {

		// GET Suppression d'un gestionnaire
		Route::get("/gestion/configuration/supprimerUtilisateur/delete/{id}", array(
			'as' => 'deletegestionnaire',
			'uses' => 'ConfigurationController@deleteGestionnaire'));

	    // GET Confirmation supression des données
		Route::get("/gestion/configuration/supprimerDonnees", array(
			'as' => 'deleteDonnees',
			'uses' => 'ConfigurationController@getConfirmationSuppression'));

		// Ensemble des routes de formulaire
		Route::group(array('before' => 'csrf'), function(){

	 	   // POST Configuration
			Route::post("/gestion/configuration", array(
				'as' => 'configuration-post',
				'uses' => 'ConfigurationController@postConfiguration'));
		});

		 	 // POST Confirmer suppression données
			Route::post("/gestion/configuration/confirmerSuppression", array(
				'as' => 'suppression-post',
				'uses' => 'ConfigurationController@postSuppression'));

			// POST Création de compte gestionnaire
			Route::post('/creerCompteGestionnaire', array(
			'as' => 'creerCompteGestionnaire-post',
			'uses' => 'ConfigurationController@postCreateCompteGestionnaire'));
	});

});