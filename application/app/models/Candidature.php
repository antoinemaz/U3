<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Candidature extends Eloquent implements UserInterface, RemindableInterface{

	use UserTrait, RemindableTrait;

	/* Ajout d'un sécurité pour interdire les actions avec ces champs*/
	protected $guarded = array('id','updated_at','created_at');

	// Liste des champs que l'utilisateur peut setter
	protected $fillable = array('email', 'password', 'password_tmp', 'code', 'active');

	// table utilisée
	protected $table = 'candidatures';
	
	protected $hidden = array('password', 'remember_token');
}