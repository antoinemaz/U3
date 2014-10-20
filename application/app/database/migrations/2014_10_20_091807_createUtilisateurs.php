<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtilisateurs extends Migration {

	
	public function up()
	{
		/* candidatures représente le nom de la table */
		Schema::create('utilisateurs', function(Blueprint $table)
		{
			/*Creation d'un champs de type autoincrement et en clé primaire*/
			$table->increments('id')->unsigned();

		    $table->string('password');
		    $table->string('password_tmp');
		    $table->string('code');
		    $table->string('remember_token');
		    $table->tinyInteger('active');
		    $table->string('email');

		    $table->integer('id_role');	
		    $table->foreign('id_role')->references('id')->on('roles');	  

			/*  created at et updated at sont créé à l'aide de timestamp()  */
			$table->timestamps();
		
		
		});
	}

	
	public function down()
	{
		Schema::drop('utilisateurs');
	}

}
