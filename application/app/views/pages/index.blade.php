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
</div>
	  <script>

	  	$(document).ready(function(){

	  		$("#erreurPj").hide();
	  		$("#charg").hide();
	  		$("#listPjs").load( {{ "'".URL::route('pjs')."'" }} );

	  		$('#form').on('submit',(function(e){

	  			e.preventDefault();

	  			if(!$('#file').val()){
	  			    $("#erreurPj").show();
	  				$("#erreurPj").html("Choisissez une pièce jointe")
	  			}else if( ($("#file")[0].files[0].size) /1048576 >= 10 ){
	  				$("#erreurPj").show();
	  				$("#erreurPj").html("Le fichier ne peut pas excéder 10 Mo.")
	  				$("#charg").hide();
	  			}else if($("#file")[0].files[0].name.split('.').pop() != 'pdf'){
	  				$("#erreurPj").show();
	  				$("#erreurPj").html("Le fichier doit être au format PDF")
	  				$("#charg").hide();
	  			}else{
	  			 $.ajax({
		  		  xhr: function(){
				    var xhr = new window.XMLHttpRequest();
				    //Upload progress
				    xhr.upload.addEventListener("progress", function(evt){
				      if (evt.lengthComputable) {
				        var percentComplete = evt.loaded / evt.total;
				        $("#charg").show();
				      	$("#charg").html("   Téléchargement du fichier : "+percentComplete*100+" %");
				      }
				    }, false);
				    return xhr; },
	             type: 'POST',
	             url: {{"'".URL::route('upload-post')."'"}},
	             data: new FormData( this ),
     			 processData: false,
      			 contentType: false,
	             success: function () {
	           
	              $("#listPjs").load( {{ "'".URL::route('pjs')."'" }} );
	              $('#form').each(function(){
  					  this.reset();
				   });

	              //$("#charg").hide();
	              $("#erreurPj").hide();
	            }
       		   });
	  		  }
	  		}));
		});
	  </script>

@stop