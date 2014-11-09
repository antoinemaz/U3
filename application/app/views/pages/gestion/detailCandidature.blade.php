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
			
			<?php
		        // Récupération de l'état de la candidature, si elle est envoyé, le formulaire ne sera plus éditable
		        $readonly = '';
		        if($candidature->etat_id != 2 and $candidature->etat_id != 3 ){
		          $readonly = 'disabled';
		        }
		    ?>

		 <form id="form" action="{{URL::route('detailCandidature-post')}}" method="POST" class="form-horizontal inscription" style="max-width: none;">

			<div class="navbar-fixed-bottom comment">
				<div class="center">
					<u>Partie réservée au gestionnaire</u>
				</div>	
			</div>

			<span class="label label-primary custom-label">Informations élémentaires</span>
		 	<div style="max-width:300px;margin: 0 auto;">
		 		@include('pages.Candidatures.partieCandidature.partieCandidature')
		 	</div>

		 	<span class="label label-primary custom-label" style="margin-top: 30px;">Diplomes</span>

		 	<!-- hidden-sm hidden-xs : TROUVER UNE SOLUTION -->
		 		@include('pages.Candidatures.partieCandidature.partieDiplome')
		 	</div>

		 	<span class="label label-primary custom-label" style="margin-top: 30px;">Stages</span>
		 	<div>
		 		@include('pages.Candidatures.partieCandidature.partieStage')
		 	</div>

		 	<span class="label label-primary custom-label" style="margin-top: 30px;">Pièces jointes</span>
		 	<div>
			 	<?php
	    		  for ($i=1; $i <= $count ; $i++) { 
	      		   ?>
	      		   	<span class="label label-default label-pj">{{$pieces[$i-1]->filename}}</span>
	        		  <div style="height: 400px;" id="pdf{{$i}}"></div>
	     		   <?php
	   			   }
	 			 ?>
		 	</div>

		 </form>

  		</div>
	</div>	

@stop