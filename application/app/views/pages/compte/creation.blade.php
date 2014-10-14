@extends('template')

@section('content')


	<div class="panel panel-default custom-panel">
 		<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de création de compte</div>
		<div class="panel-body">

				<form action="{{URL::route('creerCompte-post')}}" method="POST" class="form-horizontal inscription">
			
		<div class="form-group">
			<label for="email">Email :</label>
			{{ Form::text("email", Input::get("email"), array('class' => 'form-control')) }}
			@if($errors->has('email'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('email')}}</div>
			@endif
		</div>

		<div class="form-group">
			<label for="username">Login :</label>
			{{ Form::text("username", Input::get("username"), array('class' => 'form-control')) }}
			@if($errors->has('username'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('username')}}</div>
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
			<label for="password_again">Confirmation du mot de passe :</label>
			{{ Form::password("password_again", array('class' => 'form-control'), Input::get("password_again")) }}
			@if($errors->has('password_again'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('password_again')}}</div>
			@endif
		</div>

		<button type="submit" class="btn btn-primary">Créer le compte</button>
		{{Form::token()}}
	</form>	


  		</div>
	</div>	
@stop