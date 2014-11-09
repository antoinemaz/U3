@extends('template')

@section('content')

@include('workflow')

<div class="panel panel-default custom-panel">
  <div class="panel-heading"> <span class="glyphicon glyphicon-upload"></span> Formulaire dépôt de pièces jointes</div>
  <div class="panel-body">
    {{ Form::open(array('files'=>true, 'id' => 'form', 'class'=>'form-horizontal inscription')) }}

       <?php
            // Récupération de l'état de la candidature, si elle est envoyé, le formulaire ne sera plus éditable
            $readonly = '';
            if($etat == 2 or $etat == 3 ){
              $readonly = 'disabled';
            }
        ?>

      <div class="form-group">
          {{ Form::label('file','Fichier',array('id'=>'','class'=>'')) }}
          <input id="file" type="file" name="file" {{$readonly}}>
          <div class="alert alert-danger custom-alert" id="erreurPj" role="alert"></div>
      </div>
          <button type=button onclick="window.location='{{ route("stage-get") }}'"
          class="btn btn-primary" name = "btnPrecedent" value="btnPrecedent"  >Précédent</button>

          {{ Form::submit('Ajouter',array('id'=>'addFile', 'class' => 'btn btn-primary', $readonly)) }} 
          {{ Form::reset('Vider', array('class'=>'btn btn-info', $readonly)) }}
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