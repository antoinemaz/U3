@extends('template')

@section('content')

@if(!empty($errors->all()))
  <div class="alert alert-danger custom-alert center" role="alert">
   	La modification n'a pas eu lieu
  </div>
@endif

@if(Session::has('gestionnaire-cree'))
	<div class="alert alert-success custom-alert center" role="alert">{{Session::get('gestionnaire-cree')}}</div>
@endif
@if(Session::has('gestionnaire-supprime'))
	<div class="alert alert-success custom-alert center" role="alert">{{Session::get('gestionnaire-supprime')}}</div>
@endif
@if(Session::has('configuration-enregistre'))
	<div class="alert alert-success custom-alert center" role="alert">{{Session::get('configuration-enregistre')}}</div>
@endif

@if(Auth::user()->role_id == Constantes::ADMINISTRATEUR)
	<div class="panel panel-default custom-panel">
		<div class="panel-heading"> <span class="glyphicon glyphicon-wrench"></span> Configuration</div>
		<div class="panel-body">

			<form id="form" action="{{URL::route('configuration-post')}}" method="POST" class="form-horizontaln center">

				<div class="form-group">
					<label for="InputSexe">Envoi automatique de mails aux gestionnaires :</label>

					<input type="radio" name="sendMailsGestionnaires" value="1" <?php if($sendMailsGestionnaires == 1){ echo "checked='checked'";} ?> >Oui</input> 
					<input type="radio" name="sendMailsGestionnaires" value="0" <?php if($sendMailsGestionnaires == 0){ echo "checked='checked'";} ?> >Non</input>
				</div>

				<div class="center">
					<button id="clickConfig" type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg">Enregistrer</button>
				</div>

				{{Form::token()}}
			</form>
		</div>
	</div>	

	<div class="panel panel-default custom-panel">
		<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Gestion des comptes Gestionnaires/Administrateurs</div>
		<div class="panel-body">
			<form action="{{URL::route('creerCompteGestionnaire-post')}}" method="POST" class="form-horizontal inscription">	
				<div class="form-group">
					<label for="email">Email :</label>
					{{ Form::text("email", Input::get("email"), array('class' => 'form-control')) }}
					@if($errors->has('email'))
					<div class="alert alert-danger custom-danger" role="alert">{{$errors->first('email')}}</div>
					@endif
				</div>

				<div class="form-group">
					<label for="role">Rôle :</label>
					<select name="role" class="form-control">
						@foreach($tabRoles as $unRole) 
						<option value="{{$unRole->id}}" >{{$unRole->libelle}}</option>
					}
					@endforeach
				</select>
			</div>

			<button type="submit" class="btn btn-primary">Créer le compte</button>
			{{Form::token()}}
		</form>	

		<table class="table">
			<thead>
				<tr>
					<th>Email</th>
					<th>Rôle</th>
					<th>Action</th>
				</tr>
			</thead>

			@foreach ($gestionnairesAndAdmins as $gestionnaire)
			<tr>
				<td>{{ $gestionnaire->email }}</td>
				<td>
					@if($gestionnaire->role_id == Constantes::GESTIONNAIRE)
						Gestionnaire
					@else
						Administrateur
					@endIf
				</td>
				<td>
					@if($gestionnaire->id != 1)
						<a class="cn" id="{{$gestionnaire->id}}" class="file" 
							href="{{URL::route('deletegestionnaire',array('id' => $gestionnaire->id))}}">Supprimer</a>
					@endIf
				</td>
			</tr>
			@endforeach	
		</table>

		</div>
	</div>
@endIf

<div class="panel panel-default custom-panel">
	<div class="panel-heading"> <span class="glyphicon glyphicon-filter"></span> Filtre des candidatures</div>
	<div class="panel-body">
		TODO !
	</div>
</div>

@stop