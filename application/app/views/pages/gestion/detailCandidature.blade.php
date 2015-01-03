@extends('template')

@section('content')

		<!-- Partie javascript permettant d'ajouter les fichiers de la candidature dans la partie Pièces jointes -->
       <script type="text/javascript">
      window.onload = function (){

        <?php

          $count = 0;

          foreach ($pieces as $key => $value) {
            $count++;
            ?>
            // Javascript : instance d'un objet PDFObject pour l'affichage du PDF dans la page
            var myPDF = new PDFObject({ url: '../../uploads/<?php echo $value->uid ?>' })
            .embed('pdf'+<?php echo $count;  ?> );
            <?php
          }
        ?>
      };

      // Date picker pour tous les champs dates
	  $(document).ready(function(){

	        $('.datepicker').datepicker({
	          language: 'fr'
	        });
	  });


    </script>

	<div class="panel panel-default custom-panel">
 		<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Gestion des candidatures</div>
		<div class="panel-body">

			@if(Session::has('succes') and empty($errors->all()))
		      <div style="margin-bottom:0px;" class="alert alert-success custom-alert center" role="alert">{{Session::get('succes')}}</div>
		    @endif

		    @if(!empty($errors->all()))
		      <div style="margin-bottom:0px;" class="alert alert-danger custom-alert center" role="alert">
		        Le formulaire n'a pas pas pu être modifié
		      </div>
		    @endif
			
			<?php
		        // Récupération de l'état de la candidature, si elle est envoyé, le formulaire ne sera plus éditable
		        $readonly = '';
		        if($candidature->etat_id == Constantes::VALIDE or $candidature->etat_id == Constantes::AREVOIR
		        	or $candidature->etat_id == Constantes::REFUSE){
		          $readonly = 'disabled';
		        }

		        $hidden = '';
		        if($candidature->etat_id == Constantes::VALIDE){
		        	$hidden='style="display:none;"';
		        }
		    ?>

		 <form action="{{URL::route('detailCandidature-post', $candidature->id)}}" method="POST" class="form-horizontal inscription adminForm" style="max-width: none;">

		 	<div class="panelEtat">

				@if($candidature->etat_id == Constantes::BROUILLON)
					<div class="alert alert-info" role="alert">
						Etat de la candidature : <strong>Brouillon</strong>
					</div>
				@elseif($candidature->etat_id == Constantes::ENVOYE)
					<div class="alert alert-info" role="alert">
						Etat de la candidature : <strong>Envoyée</strong>
					</div>
					
				@elseif($candidature->etat_id == Constantes::VALIDE)
					<div class="alert alert-success" role="alert">
						Etat de la candidature : <strong>Validée</strong>
						<br/>
						Toutes les données ont été envoyées dans Redmine
					</div>
				@elseif($candidature->etat_id == Constantes::AREVOIR)
					<div class="alert alert-warning" role="alert">
						Etat de la candidature : <strong>A revoir</strong>
					</div>
				@else
					<div class="alert alert-danger" role="alert">
						Etat de la candidature : <strong>Refusée</strong>
					</div>
				@endIf
			</div>

			<span class="label label-primary custom-label">Informations élémentaires</span>
		 	<div style="max-width:300px;margin: 0 auto;">
		 		<div class="form-group" style="margin-bottom: 4px;">
		 			<label for="InputNom">Email :</label>
		 			{{$email}}
		 		</div>
		 		@include('pages.Candidatures.partieCandidature.partieCandidature')
		 	</div>

		 	<div {{$hidden}}>
			 	<span class="label label-primary custom-label" style="margin-top: 30px;">Diplomes</span>

			 	<div>
			 		@include('pages.Candidatures.partieCandidature.partieDiplome')
			 	</div>

			 	<span class="label label-primary custom-label" style="margin-top: 30px;">Stages</span>
			 	<div>
			 		@include('pages.Candidatures.partieCandidature.partieStage')
			 	</div>

			 	<div class="center" style="margin-bottom: 15px;margin-top: 35px;">
			          <button id="clickCandidature" type="submit" class="btn btn-primary" name = "btnEnregAdmin" value="btnEnregAdmin" {{$readonly}} >
			          	Sauvegarder les modifications
			          </button>
			    </div>

			 	<span class="label label-primary custom-label" style="margin-top: 30px;">Pièces jointes</span>
			 	<div>
				 	<?php
		    		  for ($i=1; $i <= $count ; $i++) { 
		      		   ?>
		      		   	<span class="label label-default label-pj">{{$pieces[$i-1]->filename}}</span>

		      		   		<a href="{{URL::route('deletepjgestion', $pieces[$i-1]->id)}}" class="deleteLink">
		      				   	<span class="glyphicon glyphicon-remove"></span> Supprimer
		      		   		</a>
		        		
		        		  <div style="height: 400px;" id="pdf{{$i}}"></div>
		     		   <?php
		   			   }
		 			 ?>
			 	</div>
			 	{{Form::token()}}
			 </form>

			 	<div class="navbar-fixed-bottom comment">

			 	<form action="{{URL::route('actionCandidature-post', $candidature->id)}}" method="POST" >
				 	<table style="margin:0 auto;">
				 		<tr>
				 			<td>
						 		<div class="center">
									<u>Partie réservée au gestionnaire</u>
									<textarea placeholder="Ce texte sera visible à l'étudiant que si vous changez l'état à A revoir" style="resize:none;" maxlength="200" class="form-control travailStage" name="commentGestionnaire" >{{ $candidature->commentaire_gestionnaire}}</textarea>
								</div>
				 			</td>
				 			<td>
				 				<div class="center" style="margin-left: 15px;">Actions possibles : </div>
				 				<div class="center" style="margin-left: 15px;">
			        				 <button type="submit" class="btn btn-success" 
			        				 name = "btnValide" value="btnArevoir" >Valider</button>
			         		  	     <button type="submit" class="btn btn-warning" 
			         		  	     name = "btnArevoir" value="btnValide" >A revoir</button>
			         		  	     <button type="submit" class="btn btn-danger" 
			         		  	     name = "btnRefuse" value="btnEnreg" >Refuser</button>
		 					   </div>
				 			</td>
				 		</tr>
				 	</table>
				 	{{Form::token()}}
				 </form>

				</div>
	  		</div>
		</div>	
	  	 <div style="height: 40px;"></div>
  	</div>
@stop