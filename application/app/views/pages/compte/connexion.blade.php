@extends('template')

@section('content')


	<div class="panel panel-default custom-panel">
 		<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de connexion</div>
		<div class="panel-body">

		@if(Session::has('connexion-probleme'))
		<p>{{Session::get('connexion-probleme')}}</p>
		@endif
		@if(Session::has('connexion-mauvais'))
		<p>{{Session::get('connexion-mauvais')}}</p>
		@endif

		<form action="{{URL::route('connexion-post')}}" method="POST" class="form-horizontal inscription">
			
		<div class="form-group">
			<label for="email">Email :</label>
			{{ Form::text("email", Input::get("email"), array('class' => 'form-control')) }}
			@if($errors->has('email'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('email')}}</div>
			@endif
		</div>

		<div class="form-group">
			<label for="password">Mot de passe :</label>
			{{ Form::password("password", array('class' => 'form-control'), Input::get("password")) }}
			@if($errors->has('password'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('password')}}</div>
			@endif
		</div>

		<button type="submit" class="btn btn-primary">Connexion</button>
		{{Form::token()}}
	</form>	


  		</div>
	</div>	
@stop