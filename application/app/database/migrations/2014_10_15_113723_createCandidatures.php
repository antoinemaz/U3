<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatures extends Migration {

	/*
	   La fonction up va permettre de créer une table en base de données.
	*/
	public function up()
	{
		/* candidatures représente le nom de la table */
		Schema::create('candidatures', function(Blueprint $table)
		{
			/*Creation d'un champs de type autoincrement et en clé primaire*/
			$table->increments('id')->unsigned();

		    $table->string('nom');
		    $table->string('prenom');
		    $table->string('password');
		    $table->string('password_tmp');
		    $table->string('code');
		    $table->string('remember_token');
		    $table->tinyInteger('active');
		    $table->integer('annee_naissance');
		    $table->string('regime_inscription');
		    $table->string('sexe');
		    $table->boolean('dossier_etrange');
		    $table->string('nationalite');
		    $table->string('email');
		    $table->integer('telephone');
		    $table->string('adresse');
		    $table->integer('codePostal');
		    $table->string('filliere');
		    $table->string('dernier_diplome');
		    $table->integer('annee_dernier_diplome');
		    $table->string('commentaire_gestionnaire');
		    $table->string('erreur_info');
		    $table->integer('redmine_id');

		    $table->integer('id_etat');
		    $table->foreign('id_etat')->references('id')->on('etats');
		    $table->integer('id_user');	
		    $table->foreign('id_user')->references('id')->on('utilisateurs');	  

			/*  created at et updated at sont créé à l'aide de timestamp()  */
			$table->timestamps();
		
		
		});

       
	}
	

	/**
	 *  La fonction down va permettre de supprimer une table en base de données.
	 */
	public function down()
	{
		Schema::drop('candidatures');
	}

}