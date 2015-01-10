@extends('template')

@section('content')

@if(!empty($errors->all()))
  <div class="alert alert-danger custom-alert center" role="alert">
   	La modification n'a pas eu lieu
  </div>
@endif

@if(Session::has('CoupleAnneeFilliere-add'))
	<div class="alert alert-success custom-alert center" role="alert">{{Session::get('CoupleAnneeFilliere-add')}}</div>
@endif
@if(Session::has('CoupleAnneeFilliere-supprime'))
	<div class="alert alert-success custom-alert center" role="alert">{{Session::get('CoupleAnneeFilliere-supprime')}}</div>
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

		   <?php

              $date_debut_periode = null;
              $date_fin_periode = null;

              if($properties->date_debut_periode != null){
                
                if($date_debut_periode == '00/00/0000'){
                  $date_debut_periode = null;
                }else{
                   $dateDebutSplite = explode("-", $properties->date_debut_periode);
                   $date_debut_periode = $dateDebutSplite[2].'/'.$dateDebutSplite[1].'/'.$dateDebutSplite[0];
                }
              }

              if($properties->date_fin_periode != null){

                if($date_fin_periode == '00/00/0000'){
                    $date_fin_periode = null;
                }else{
                    $dateFinSplite = explode("-", $properties->date_fin_periode);
                    $date_fin_periode = $dateFinSplite[2].'/'.$dateFinSplite[1].'/'.$dateFinSplite[0];
                }
              }
            ?>


            <form id="form" action="{{URL::route('configuration-post')}}" method="POST" class="form-horizontaln center">

            	<div class="form-group">
            		<label>Envoi automatique de mails aux gestionnaires :</label>

            		<input type="radio" name="sendMailsGestionnaires" value="1" <?php if($properties->active == 1){ echo "checked='checked'";} ?> >Oui</input> 
            		<input type="radio" name="sendMailsGestionnaires" value="0" <?php if($properties->active == 0){ echo "checked='checked'";} ?> >Non</input>
            	</div>

            	<div class="panel panel-default" style="margin: 0 auto 15px;max-width: 500px;">
            		<div class="panel-heading"><strong style="color:black;">Période d'inscription</strong></div>
            		<div class="panel-body">
            			<div class="form-inline">
            				<div class="form-group">
            					<label for="date_deb">Date de début</label>
            					<input type="text" class="datepickerDeb form-control mydate" style="width:100px;" name="date_deb" 
            					value="{{ $date_fin_periode }}" />
            					@if($errors->has('date_deb'))
            						<div class="alert alert-danger custom-alert" role="alert">{{$errors->first('date_deb')}}</div>
            					@endif

            					<label for="date_fin">Date de fin</label>
            					<input type="text" class="datepickerFin form-control mydate" style="width:100px;" name="date_fin" 
            					value="{{ $date_fin_periode }}" />
            					@if($errors->has('date_fin'))
            						<div class="alert alert-danger custom-alert" role="alert">{{$errors->first('date_fin')}}</div>
            					@endif
            				</div>
            			</div>
            		</div>
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
						<a  id="{{$gestionnaire->id}}" 
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

		<form action="{{URL::route('ajouterCoupleAnneeFiliere-post')}}" method="POST" class="form-horizontal inscription">	
				
				<div class="form-group">
      			<label for="annee">Année :</label>
        		{{ Form::select('annee', $annee_convoitee,null, array('class' => 'form-control')) }}
    			</div>

				<div class="form-group">
					<label for="filliere">Fillière :</label>
					<select name="filliere" class="form-control">
						@foreach($tabFiliere as $uneFilliere) 
						<option>{{$uneFilliere}}</option>
					}
					@endforeach
				    </select>
			    </div>

			<button type="submit" class="btn btn-primary">Ajouter</button>
			{{Form::token()}}
		</form>	

		<table class="table">
			<thead>
				<tr>
					<th>Année</th>
					<th>Fillière</th>
					<th>Action</th>
				</tr>
			</thead>

			@foreach ($coupleAnneeFilliere as $couple)
			<tr>
				<td>{{ $annee_convoitee[$couple->annee_resp] }}</td>
				<td>{{ $couple-> filiere_resp }}
				</td>
				<td>
						<a id="{{$couple->id}}"
							href="{{URL::route('deleteCouple',array('id' => $couple->id))}}">Supprimer</a>
				</td>
			</tr>
			@endforeach	
		</table>

	</div>
</div>

<script>
$(document).ready(function(){

	$('.datepickerDeb').datepicker({
		language: 'fr'
	});
	$('.datepickerFin').datepicker({
		language: 'fr'
	});
});
</script>

@stop