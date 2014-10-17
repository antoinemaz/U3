<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePieces extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
				Schema::create('pieces', function($table)
		{
			/*Creation d'un champs de type autoincrement et en clé primaire*/
			$table->increments('id')->unisgned();
		    $table->string('uid');
		    $table->string('filename');
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
