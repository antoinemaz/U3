<?php

class Etat extends Eloquent{

	protected $guarded = array('id');
	
	protected $table = 'etats';

	public $timestamps = false;

}