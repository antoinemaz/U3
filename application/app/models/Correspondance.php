<?php

class Correspondance extends Eloquent {

	// table utilisée
	protected $table = 'correspondances';

	/* Ajout d'un sécurité pour interdire les actions avec ces champs*/
	protected $guarded = array('id');

	
}