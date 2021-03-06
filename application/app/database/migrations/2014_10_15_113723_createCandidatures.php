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
		Schema::create('candidatures', function($table)
		{
			/*Creation d'un champs de type autoincrement et en clé primaire*/
			$table->increments('id')->unsigned();

		    $table->string('nom');
		    $table->string('prenom');		 
		    $table->date('date_naissance')->nullable();
		    $table->string('lieu_naissance');
		    $table->string('regime_inscription');
		    $table->string('sexe');
		    $table->boolean('dossier_etrange');
		    $table->string('nationalite');
		    $table->string('telephone');
		    $table->string('adresse');
		    $table->string('codePostal');
		    $table->string('ville');
		    $table->string('pays');
		    $table->string('filiere');
		    $table->date('date_dernier_diplome')->nullable();
		    $table->longtext('commentaire_gestionnaire');
		    $table->integer('annee_convoitee');
		    $table->boolean('complet');
		    $table->integer('project_id_redmine');

		    $table->integer('etat_id')->unsigned();
		    $table->foreign('etat_id')->references('id')->on('etats');
		    $table->integer('utilisateur_id')->unsigned();
		    $table->foreign('utilisateur_id')->references('id')->on('utilisateurs');	  

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