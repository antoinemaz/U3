<?php

class Role extends Eloquent{

	protected $guarded = array('id');

	protected $table = 'roles';

	public $timestamps = false;

}