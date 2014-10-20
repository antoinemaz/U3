<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Utilisateur extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	// Table utilisée
	protected $table = 'utilisateurs';

	protected $fillable = array('email', 'password', 'password_tmp', 'code', 'active', 'role_id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
}
