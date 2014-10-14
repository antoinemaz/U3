<?php

class RedmineController extends BaseController {

	public function run(){

		$client = new RedmineClient();
		$users = $client->postValues('roles');

		return View::make("hello")->with('var', "Coucou");
	}
}
