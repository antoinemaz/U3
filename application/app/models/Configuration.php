<?php

class Configuration extends Eloquent{

	protected $guarded = array('id');

	protected $table = 'configurations';

	public $timestamps = false;

}