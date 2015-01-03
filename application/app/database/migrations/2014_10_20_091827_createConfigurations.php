<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateConfigurations extends Migration {

	public function up()
	{
		/* candidatures représente le nom de la table */
		Schema::create('configurations', function(Blueprint $table)
		{
			/*Creation d'un champs de type autoincrement et en clé primaire*/
			$table->increments('id')->unsigned();
			$table->string('libelle');
			$table->boolean('active');

		});
	}
	
	public function down()
	{
		Schema::drop('configurations');
	}
}