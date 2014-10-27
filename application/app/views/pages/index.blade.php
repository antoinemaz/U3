@extends('template')

@section('content')

	@if(Session::has('compte-impossible-active'))
		<p>{{Session::get('compte-impossible-active')}}</p>
	@endif
	@if(Session::has('compte-active'))
		<p>{{Session::get('compte-active')}}</p>
	@endif	
	@if(Session::has('password_changed'))
		<p>{{Session::get('password_changed')}}</p>
	@endif	
	@if(Session::has('password_reinit'))
		<p>{{Session::get('password_reinit')}}</p>
	@endif
	@if(Session::has('validation_password_oublie'))
		<p>{{Session::get('validation_password_oublie')}}</p>
	@endif	
	@if(Session::has('error_forget_password_init'))
		<p>{{Session::get('error_forget_password_init')}}</p>
	@endif	
	@if(Auth::check())
		<p>Salut {{Auth::user()->email}} </p>
	@else
		<p> Vous n'êtes pas connecté</p>
	@endif

<div class="panel panel-default custom-panel">
	<div class="panel-heading"> <span class="glyphicon glyphicon-upload"></span> Formulaire dépôt de pièces jointes</div>
	<div class="panel-body">
	  {{ Form::open(array('files'=>true, 'id' => 'form', 'class'=>'form-horizontal inscription')) }}
	  <div class="form-group">
	  		{{ Form::label('file','Fichier',array('id'=>'','class'=>'')) }}
	  		{{ Form::file('file','',array('id'=>'file','class'=>'')) }}
	  		<div class="alert alert-danger custom-danger" id="erreurPj" role="alert"></div>
	  </div>

	  		{{ Form::submit('Enregistrer',array('id'=>'addFile', 'class' => 'btn btn-primary')) }} 
	  		{{ Form::reset('Vider', array('class'=>'btn btn-info')) }}
	  		<div style="margin-top:12px;" class="label label-info" id="charg"></div>	
	  
	  {{ Form::close() }}
	  <div id="listPjs"></div>
	</div>

	<input id="dp1" class="datepicker" type="text">


	<form action="{{URL::route('diplome-post')}}" method="POST" class="form-horizontal">

			<table id="diplomes" class="table table-striped dataTable no-footer" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Nom</th>
						<th>libelle</th>
					</tr>
				</thead>

			    <tbody>
					<tr>
						<td>aaa</td>
						<td>
							<input name="libelle1" type="text">
						</td>
					</tr>
				</tbody>
		</table>
		{{Form::token()}}
		<button type="submit" class="btn btn-primary">Enregistrer</button>

	</form>

</div>
	  <script>

	  	$(document).ready(function(){

	  		$('.datepicker').datepicker({
	  			language: 'fr'
	  		});

	  		$("#erreurPj").hide();
	  		$("#charg").hide();
	  		$("#listPjs").load( {{ "'".URL::route('pjs')."'" }} );

	  		$('#form').on('submit',(function(e){

	  			// Désactive l'action par défaut de l'évènement (du submit du form dans ce cas)
	  			e.preventDefault();

	  			// On récupère les properties pour avoir la taille max des fichiers 
	  			<?php
	  				$properties = parse_ini_file("properties.ini");
	  			?>
	  			var sizeMaxUploadFile = "<?php Print($properties['sizeMaxUploadFile']); ?>";


	  			if(!$('#file').val()){
	  			    $("#erreurPj").show();
	  				$("#erreurPj").html("Choisissez une pièce jointe ");

	  			// Test sur la taille du fichier (en Mo)	
	  			}else if( ($("#file")[0].files[0].size) /1048576 >= sizeMaxUploadFile ){
	  				$("#erreurPj").show();
	  				$("#erreurPj").html("Le fichier ne peut pas excéder "+ sizeMaxUploadFile +" Mo.")
	  				$("#charg").hide();

	  			// Test du format du fichier à tester	
	  			}else if($("#file")[0].files[0].name.split('.').pop() != 'pdf'){
	  				$("#erreurPj").show();
	  				$("#erreurPj").html("Le fichier doit être au format PDF")
	  				$("#charg").hide();
	  			}else{

	  			// Fonction ajax de jquery	
	  			 $.ajax({
	  			 // Appel une fonction callback (fonction ajax, qui appelle la fonction suivante)
		  		  xhr: function(){
		  		  	// Création d'un objet XMLHTTPREQUEST (objet permettant d'échanger des données entre client et serveur)
				    var xhr = new window.XMLHttpRequest();
				    // évènement de progression pour l'envoi et la récéption de données
				    xhr.upload.addEventListener("progress", function(evt){
				      // si l'évènement d'upload a une taille 
				      if (evt.lengthComputable) {
				      	// calcul de la taille chargée / taille totale
				        var percentComplete = evt.loaded / evt.total;
				        $("#charg").show();
				      	$("#charg").html("   Téléchargement du fichier : "+percentComplete*100+" %");
				      }
				    }, false);
				    return xhr; },
	             type: 'POST',
	             // Url de la route de traitement post
	             url: {{"'".URL::route('upload-post')."'"}},
	             // les données envoyées seront les données du formulaire
	             data: new FormData( this ),
	             // Empeche l'envoie d'une string à l'attribue data
     			 processData: false,
     			 // Cela permet de passer le formulaire en multipart/form-data 
      			 contentType: false,
	             success: function () {
	           
	              $("#listPjs").load( {{ "'".URL::route('pjs')."'" }} );
	              $('#form').each(function(){
  					  this.reset();
				   });

	              $("#erreurPj").hide();
	            }
       		   });
	  		  }
	  		}));
		});
	  </script>

@stop