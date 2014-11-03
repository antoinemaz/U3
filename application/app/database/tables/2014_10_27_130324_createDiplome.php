<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiplome extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* diplomes représente le nom de la table */
		Schema::create('diplomes', function($table)
		{
			/*Creation d'un champs de type autoincrement et en clé primaire*/
			$table->increments('id')->unsigned();
			$table->string('libelle');
		    $table->integer('annee');
		    $table->string('etablissement');
		    $table->string('diplome');
		    $table->integer('moyenne_annee');
		    $table->string('mention');
		    $table->string('rang');
		    $table->integer('numero');
		    $table->integer('candidature_id')->unsigned();
		    $table->foreign('candidature_id')->references('id')->on('candidatures');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
