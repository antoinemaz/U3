@extends('template')

@section('content')


	<div class="panel panel-default custom-panel">
 		<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de création de gestionnaire</div>
		<div class="panel-body">

				<form action="{{URL::route('creerCompteGestionnaire-post')}}" method="POST" class="form-horizontal inscription">
			
		<div class="form-group">
			<label for="email">Email :</label>
			{{ Form::text("email", Input::get("email"), array('class' => 'form-control')) }}
			@if($errors->has('email'))
				<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('email')}}</div>
			@endif
		</div>
		<button type="submit" class="btn btn-primary">Créer le compte</button>
		{{Form::token()}}
	</form>	


  		</div>
	</div>	
@stop