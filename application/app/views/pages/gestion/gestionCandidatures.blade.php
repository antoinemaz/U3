@extends('template')

@section('content')

	<div class="panel panel-default custom-panel">
 		<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Gestion des candidatures</div>
		<div class="panel-body">
			
			<table id="candidatures" class="table table-condensed" width="100%" cellspacing="0">

				<thead>
					<tr>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Détail</th>
					</tr>
				</thead>

    		    <tbody>
					@foreach ($candidatures as $cand)
					<tr>
						<td>{{ $cand->nom }}</td>
						<td>{{ $cand->prenom }}</td>
						<td><a href="{{URL::route('password-oublie-get')}}">Détail</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>

  		</div>
	</div>	

	<script>

		$(document).ready(function() {

		    $('#candidatures').dataTable({
		    	"oLanguage": {
		    		    "sProcessing":     "Traitement en cours...",
					    "sSearch":         "Rechercher&nbsp;:",
					    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
					    "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
					    "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
					    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
					    "sInfoPostFix":    "",
					    "sLoadingRecords": "Chargement en cours...",
					    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
					    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
					    "oPaginate": {
					        "sFirst":      "Premier",
					        "sPrevious":   "Pr&eacute;c&eacute;dent",
					        "sNext":       "Suivant",
					        "sLast":       "Dernier"
					    },
					    "oAria": {
					        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
					        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
   						 }
				}
		    });
		
		});

	</script>

@stop