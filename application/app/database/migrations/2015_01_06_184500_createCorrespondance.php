<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCorrespondance extends Migration {
	
	public function up()
	{
		Schema::create('correspondances', function($table)
		{
			/*Creation d'un champs de type autoincrement et en clé primaire*/
			$table->increments('id')->unsigned();
			$table->string('iduser');
			$table->string('filiere_resp');
			$table->integer('annee_resp');
			$table->foreign('iduser')->references('id')->on('utilisateurs');
			/* created at et updated at sont créé à l'aide de timestamp() */
			$table->timestamps();
		});
	}
	public function down()
	{
		Schema::drop('correspondances');
	}
}