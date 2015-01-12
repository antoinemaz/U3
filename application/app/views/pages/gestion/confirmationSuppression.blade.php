@extends('template')

@section('content')

@if(Session::has('delete-impossible'))
	<div class="alert alert-danger custom-alert center" role="alert">{{Session::get('delete-impossible')}}</div>
@endif

@if(Auth::user()->role_id == Constantes::ADMINISTRATEUR)

	<?php

   		// On va disabled le bouton qui permet de supprimer les données
   		// si on est hors de la période d'inscription
   		$disabledDelete = '';
    	date_default_timezone_set('Europe/Paris');
    	$now = date("Y-m-d");
    	if($now >= $properties->date_debut_periode && $now <= $properties->date_fin_periode ){
    		$disabledDelete = 'disabled';
    	}
	?>

	@if(!$disabledDelete)
		<div class="panel panel-default custom-panel">
			<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span>Confirmation de la suppression des données</div>
			
			<a href="{{URL::route('configuration-get')}}"> << Retour à la configuration</a>
			<div class="panel-body">
				<div class="center">
					La période d'inscription est close.
					Vous avez la possibilité de supprimer les données de l'application.<br/>
					Si vous réalisez cette action, voici la liste des données qui seront suppriméees :<br/>
					<div style="margin: 5px auto 0px 38%;">
						<ul style="text-align: left; margin: 0px auto;">
							<li>les utilisateurs</li>
							<li>les candidatures </li>
							<li>les pièces jointes</li>
						</ul>
					</div>
				</div>

				<form action="{{URL::route('suppression-post')}}" method="POST" class="form-horizontal inscription">	
					<div class="form-group">
						<label for="password">Mot de passe :</label>
						{{ Form::password("password", array('class' => 'form-control'), Input::get("password")) }}
						@if($errors->has('password'))
							<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('password')}}</div>
						@endif
					</div>
					 <button id="clickDelete" type="submit" class="btn btn-danger" name = "btnDelete" value="btnEnreg" {{$disabledDelete}}>
	            		Supprimer toutes les candidatures
	            	</button>
	            </div>
	        </form>	
			</div>
		</div>

	@else
		<div>Action impossible. La période d'inscription n'est pas terminée.</div>
	@endIf
@endIf

@stop