@extends('template')

@section('content')

	@if(Session::has('compte-impossible-active'))
		<p>{{Session::get('compte-impossible-active')}}</p>
	@endif
	@if(Session::has('compte-active'))
		<p>{{Session::get('compte-active')}}</p>
	@endif	
	@if(Session::has('password_changed'))
		<p>{{Session::get('password_changed')}}</p>
	@endif	
	@if(Auth::check())
		<p>Salut {{Auth::user()->email}} </p>
	@else
		<p> Vous n'êtes pas connecté</p>
	@endif
@stop