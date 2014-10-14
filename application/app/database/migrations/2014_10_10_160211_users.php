<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('email', 64)->unique();
			$table->string('username')->unique();
			$table->string('password');
			$table->string('password_tmp');
			$table->string('code');
			$table->string('remember_token', 64);
			$table->tinyInteger('active');
			$table->timestamps();
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
