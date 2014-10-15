@extends('template')

@section('content')


	<div class="panel panel-default custom-panel">
 		<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de connexion</div>
		<div class="panel-body">

		<form action="{{URL::route('changerpassword-post')}}" method="POST" class="form-horizontal inscription">
			
		<div class="form-group">
			<label for="oldpassword">Ancien mot de passe :</label>
			{{ Form::password("oldpassword", array('class' => 'form-control'), Input::get("oldpassword")) }}
			@if($errors->has('oldpassword'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('oldpassword')}}</div>
			@endif
		</div>

		<div class="form-group">
			<label for="password">Nouveau mot de passe :</label>
			{{ Form::password("password", array('class' => 'form-control'), Input::get("password")) }}
			@if($errors->has('password'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('password')}}</div>
			@endif
		</div>

		<div class="form-group">
			<label for="password_again">Réécrire le mot de passe :</label>
			{{ Form::password("password_again", array('class' => 'form-control'), Input::get("password_again")) }}
			@if($errors->has('password_again'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('password_again')}}</div>
			@endif
		</div>

		<button type="submit" class="btn btn-primary">Changer</button>
		{{Form::token()}}
	</form>	
  		</div>
	</div>	
@stop