<?php

class HomeController extends BaseController {

	public function index()
	{
		return View::make('pages.index')->with('test',Active::route('foo'));
	}

}
