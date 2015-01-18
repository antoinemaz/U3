@extends('template')

@section('content')

	@if(Session::has('erreur_passord_oublie'))
		<div class="alert alert-danger custom-alert center" role="alert">
			{{Session::get('erreur_passord_oublie')}}
		</div>
	@endif

	<div class="panel panel-default custom-panel">
 		<div class="panel-heading"> <span class="glyphicon glyphicon-wrench"></span> Mot de passe oublié</div>
		<div class="panel-body">

		@if(Session::has('error_change_password'))
			<div class="alert alert-danger custom-alert center" role="alert">
				{{Session::get('error_change_password')}}
			</div>
		@endif
		@if(Session::has('ancien_passord_incorrect'))
			<div class="alert alert-danger custom-alert center" role="alert">
				{{Session::get('ancien_passord_incorrect')}}
			</div>
		@endif
		<form action="{{URL::route('password-oublie-post')}}" method="POST" class="form-horizontal inscription">
			
		<div class="form-group">
			<label for="email">Email :</label>
			{{ Form::text("email", Input::get("email"), array('class' => 'form-control')) }}
			@if($errors->has('email'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('email')}}</div>
			@endif
		</div>


		<button type="submit" class="btn btn-primary">Envoyer</button>
		{{Form::token()}}
	</form>	
  		</div>
	</div>	
@stop