<?php

class Candidature extends Eloquent {

	// table utilisée
	protected $table = 'candidatures';

	/* Ajout d'un sécurité pour interdire les actions avec ces champs*/
	protected $guarded = array('id');

	// Liste des champs que l'utilisateur peut setter
	protected $fillable = array('email', 'password', 'password_tmp', 'code', 'active');
	
	public $timestamps = false;
}