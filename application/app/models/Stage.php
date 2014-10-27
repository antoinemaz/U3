<?php

class Stage extends Eloquent{

	protected $guarded = array('id');
	
	protected $table = 'stages';

	public $timestamps = false;

}