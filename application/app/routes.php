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
	});
});