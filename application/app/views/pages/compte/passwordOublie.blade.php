@extends('template')

@section('content')

	@if(Session::has('erreur_passord_oublie'))
	<p>{{Session::get('erreur_passord_oublie')}}</p>
	@endif

	<div class="panel panel-default custom-panel">
 		<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de connexion</div>
		<div class="panel-body">

		@if(Session::has('error_change_password'))
			<p>{{Session::get('error_change_password')}}</p>
		@endif
		@if(Session::has('ancien_passord_incorrect'))
			<p>{{Session::get('ancien_passord_incorrect')}}</p>
		@endif
		<form action="{{URL::route('password-oublie-post')}}" method="POST" class="form-horizontal inscription">
			
		<div class="form-group">
			<label for="email">Email :</label>
			{{ Form::text("email", Input::get("email"), array('class' => 'form-control')) }}
			@if($errors->has('email'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('email')}}</div>
			@endif
		</div>


		<button type="submit" class="btn btn-primary">Changer</button>
		{{Form::token()}}
	</form>	
  		</div>
	</div>	
@stop