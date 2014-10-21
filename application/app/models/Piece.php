<?php

class Piece extends Eloquent{

	protected $table = 'pieces';

	#protected $fillable = array('uid', 'filename', 'candidature_id');

	protected $guarded = array('id');

	public $timestamps = false;

}