<?php

class Candidature extends Eloquent{

	/* Ajout d'un sécurité pour interdire les actions avec ces champs*/

	protected $guarded = array('id','updated_at','created_at');

	
}