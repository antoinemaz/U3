<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* stages représente le nom de la table */
		Schema::create('stages', function($table)
		{
			/*Creation d'un champs de type autoincrement et en clé primaire*/
			$table->increments('id')->unsigned();
			$table->date('date_debut');
			$table->date('date_fin');
		    $table->string('nom');
		    $table->string('adresse');
		    $table->string('travail_effectue');
		    $table->integer('moyenne_annee');
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
