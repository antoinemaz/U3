<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEtat extends Migration {

	
	public function up()
	{
		
		/* candidatures représente le nom de la table */
		Schema::create('etats', function(Blueprint $table)
		{
			/*Creation d'un champs de type autoincrement et en clé primaire*/
			$table->increments('id')->unsigned();
		    $table->string('libelle');
	  
			/*  created at et updated at sont créé à l'aide de timestamp()  */
			$table->timestamps();
		
		});

	}

	
	public function down()
	{
		
		Schema::drop('etats');

	}

}
