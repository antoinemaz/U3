@extends('template')

@section('content')

	<div class="panel panel-default custom-panel">
 		<div class="panel-heading"> <span class="glyphicon glyphicon-log-in"></span> Connexion au portail</div>
		<div class="panel-body">

		@if(Session::has('connexion-probleme'))
			<div class="alert alert-danger custom-alert center" role="alert">
				{{Session::get('connexion-probleme')}}
			</div>	
		@endif
		@if(Session::has('connexion-mauvais'))
			<div class="alert alert-danger custom-alert center" role="alert">
				{{Session::get('connexion-mauvais')}}
			</div>	
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

		<div class="form-group">
			{{Form::checkbox('remember', 'value')}};
			<label for="remember">Se souvenir de moi</label>
		</div>

		<button type="submit" class="btn btn-primary">Connexion</button>
		{{Form::token()}}
	</form>	
  		</div>
	</div>	
@stop