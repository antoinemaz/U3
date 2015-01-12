@extends('template')

@section('content')

@if(Session::has('delete-impossible'))
	<div class="alert alert-danger custom-alert center" role="alert">{{Session::get('delete-impossible')}}</div>
@endif


@if(Auth::user()->role_id == Constantes::ADMINISTRATEUR)
	<div class="panel panel-default custom-panel">
		<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span>Confirmation de la suppression des données</div>
		<div class="panel-body">

			<form action="{{URL::route('suppression-post')}}" method="POST" class="form-horizontal inscription">	
				<div class="form-group">
					<label for="password">Mot de passe :</label>
					{{ Form::password("password", array('class' => 'form-control'), Input::get("password")) }}
					@if($errors->has('password'))
						<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('password')}}</div>
					@endif
				</div>
				 <button id="clickDelete" type="submit" class="btn btn-danger" name = "btnDelete" value="btnEnreg">
            		Supprimer toutes les candidatures
            	</button>
			</form>	
		</div>
	</div>
@endIf

@stop