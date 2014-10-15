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
			$table->increments('id')->unisgned();

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
		  

			/*  created at et updated at sont créé à l'aide de timestamp()  */
			$table->timestamps();
		
		
		});

        /* Il y a possiblité de mettre des infos dans le post afin de rentrer des
        occurences directement dans la table 
		Post::create([
			'nom' => 'nomtest',
			'prenom' => 'prenomtest',
			'annee_naissance' => '1991',
			'regime_inscription' => 'apprentissage',
			'sexe' => 'M',
			'dossier_etrange' => '1',
			'nationalite' => 'francaise',
			'mail' => 'mat2leuleu@hotmail.fr',
			'telephone' => '0170653412',
			'pj' => 'ajouter une PJ',
			'adresse' => '40 rue de la pommeraie',
			'codePostal' => '91630',
			'dernier_diplome' => 'Licence MIAGE',
			'annee_dernier_diplome' => '2013',
			'redmine_id' => '1',
			]);

			*/
	}
	

	/**
	 *  La fonction down va permettre de supprimer une table en base de données.
	 */
	public function down()
	{
		Schema::drop('candidatures');
	}

}