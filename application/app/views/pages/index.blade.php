@extends('template')

@section('content')

<div class="panel panel-default custom-panel center">
	@if(Session::has('compte-impossible-active'))
		<p>{{Session::get('compte-impossible-active')}}</p>
	@endif
	@if(Session::has('compte-active'))
		<p>{{Session::get('compte-active')}}</p>
	@endif
	@if(Session::has('password_changed'))
		<p>{{Session::get('password_changed')}}</p>
	@endif
	@if(Session::has('password_reinit'))
		<p>{{Session::get('password_reinit')}}</p>
	@endif
	@if(Session::has('validation_password_oublie'))
	<p>{{Session::get('validation_password_oublie')}}</p>
		@endif
	@if(Session::has('error_forget_password_init'))
		<p>{{Session::get('error_forget_password_init')}}</p>
	@endif
	@if(Auth::check())
		<p>Salut {{Auth::user()->email}} </p>
	@else
		<p> Vous n'êtes pas connecté</p>
	@endif

	<br/>
	Contenu de la page d'accueil à définir
</div>

@stop