<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------

/*
Page d'accueil
*/
Route::get("/", array(
	'as' => 'index',
	'uses' => 'HomeController@index'));

Route::group(array('before' => 'guest'), function(){

	Route::group(array('before' => 'csrf'), function(){
		
		/*
		POST création de compte
		*/
		Route::post('/creerCompte', array(
			'as' => 'creerCompte-post',
			'uses' => 'CompteController@postCreateCompte'));

		Route::post('/compte/connexion', array(
		'as' => 'connexion-post',
		'uses' => 'CompteController@postConnexion'));
	});

		/*
		GET création de compte
		*/
	Route::get('compte/creer', array(
		'as' => 'creerCompte-get',
		'uses' => 'CompteController@getCreateCompte'));

	Route::get('compte/activation/{code}', array(
	'as' => 'activerCompte',
	'uses' => 'CompteController@getActivationCompte'));

	Route::get('/compte/connexion', array(
		'as' => 'connexion-get',
		'uses' => 'CompteController@getConnexion'));
});

/*Si on est authentifié*/
Route::group(array('before' => 'auth'), function(){

		Route::group(array('before' => 'csrf'), function(){

			 Route::post('/compte/changerpassword', array(
			'as' => 'changerpassword-post',
			'uses' => 'CompteController@postChangerPassword'));

			 Route::post('/creerCandidature', array(
			'as' => 'creationCandidature-post',
			'uses' => 'CandidatureController@postCreateCandidature'));
		});

		 Route::get('/creerCandidature', array(
		'as' => 'creationCandidature-get',
		'uses' => 'CandidatureController@getCreateCandidature'));	

		Route::get('/compte/deconnexion', array(
		'as' => 'deconnexion-get',
		'uses' => 'CompteController@getDeconnexion'));

		Route::get('/compte/changerpassword', array(
		'as' => 'changerpassword-get',
		'uses' => 'CompteController@getChangerPassword'));
});