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

Route::get("/pjs", array('as' => 'pjs', function(){
	if(Request::ajax()){
			return App::make('HomeController')->showPjs(); 
	}
}));

Route::post("/upload", array(
	'as' => 'upload-post',
	'uses' => 'HomeController@upload'));

Route::get("/upload/delete/{id}", array(
	'as' => 'deletepj',
	'uses' => 'HomeController@deletePj'));

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
	 Route::get('/creerCandidature', array(
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

	// SI c'est un gestionnaire
	Route::group(array('before' => 'gestionnaire'), function() {

		// GET Page de gestion des gestionnaires
		Route::get('compte/gestionnaires', array(
			'as' => 'gestionnaires-get',
			'uses' => 'CompteController@getGestionGestionnaires'));

		// GET Suppression d'un gestionnaire
	    Route::get("/compte/gestionnaire/delete/{id}", array(
			'as' => 'deletegestionnaire',
			'uses' => 'CompteController@deleteGestionnaire'));


	    // GET Liste des candidatures
	    Route::get("/gestion/listeCandidatures", array(
			'as' => 'listeCandidatures-get',
			'uses' => 'GestionController@getListeCandidatures'));

		// Ensemble des routes de formulaire gestionnaire
		Route::group(array('before' => 'csrf'), function(){
			
			// POST Création de compte gestionnaire
			Route::post('/creerCompteGestionnaire', array(
				'as' => 'creerCompteGestionnaire-post',
				'uses' => 'CompteController@postCreateCompteGestionnaire'));
		});
	});

		 // GET Test tableau de diplome et stage
		 Route::get('/testDiplome', array(
		'as' => 'diplome-get',
		'uses' => 'HomeController@getDiplome'));

		 // GET téléchargement fichier PDF
		 Route::get('/download', array(
		 	'as' => 'download',
		 	'uses' => 'HomeController@getDownload'));

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

		  // POST Test tableau de diplome et stage
		 Route::post('/testDiplome', array(
		'as' => 'diplome-post',
		'uses' => 'HomeController@testDiplome'));
	});
});