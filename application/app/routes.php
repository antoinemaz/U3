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
	});

		/*
		GET création de compte
		*/
	Route::get('compte/creer', array(
		'as' => 'creerCompte-get',
		'uses' => 'CompteController@getCreateCompte'));
});

Route::get('compte/activation/{code}', array(
	'as' => 'activerCompte',
	'uses' => 'CompteController@getActivationCompte'));