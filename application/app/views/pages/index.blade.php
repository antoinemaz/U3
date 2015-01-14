@extends('template')

@section('content')

<div class="panel panel-default custom-panel center">
	@if(Session::has('compte-cree'))
		<div class="alert alert-success custom-alert center" role="alert">
			{{Session::get('compte-cree')}}
		</div>
	@endif
	@if(Session::has('compte-impossible-active'))
		<div class="alert alert-danger custom-alert center" role="alert">
			{{Session::get('compte-impossible-active')}}
		</div>
	@endif
	@if(Session::has('compte-active'))
		<div class="alert alert-success custom-alert center" role="alert">
			{{Session::get('compte-active')}}
		</div>
	@endif
	@if(Session::has('password_changed'))
		<div class="alert alert-success custom-alert center" role="alert">
			{{Session::get('password_changed')}}
		</div>
	@endif
	@if(Session::has('password_reinit'))
		<div class="alert alert-success custom-alert center" role="alert">
			{{Session::get('password_reinit')}}
		</div>
	@endif
	@if(Session::has('validation_password_oublie'))
		<div class="alert alert-success custom-alert center" role="alert">
			{{Session::get('validation_password_oublie')}}
		</div>
	@endif
	@if(Session::has('error_forget_password_init'))
		<div class="alert alert-danger custom-alert center" role="alert">
			{{Session::get('error_forget_password_init')}}
		</div>
	@endif

	@if(Auth::check())
		<p>Bonjour, vous êtes connecté avec l'adresse mail suivante : {{Auth::user()->email}} </p>
	@else
		<p> Vous n'êtes pas connecté</p>
	@endif

	<br/>
	Contenu de la page d'accueil à définir
</div>

@stop