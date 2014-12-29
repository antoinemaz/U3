@extends('template')

@section('content')

@include('workflow')

<div class="panel panel-default custom-panel">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body">

    @if(Session::has('succes'))
      <div id="succes" class="alert alert-success custom-alert center" role="alert">{{Session::get('succes')}}</div>
    @endif

    <div id="error" class="alert alert-danger custom-alert center" role="alert">{{Session::get('customError')}}</div>

     @if(!empty($errors->all()))
      <div id='errorServer' class="alert alert-danger custom-alert center" role="alert">
        {{$errors->first()}}
      </div>
    @endif

      <?php
          // Récupération de l'état de la candidature, si elle est envoyé, le formulaire ne sera plus éditable
          $readonly = '';
          if($etat == Constantes::ENVOYE or $etat == Constantes::VALIDE or $etat == Constantes::REFUSE){
            $readonly = 'disabled';
          }
      ?>

    <form action="{{URL::route('diplome-post')}}" id="form" method="POST" class="form-horizontal" style="text-align:center;">


      @include('pages.Candidatures.partieCandidature.partieDiplome')

        <button type="submit" class="btn btn-primary" name = "btnPrecedent" value="btnPrecedent" >Précédent</button>
        <button id="clickDiplome" type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg" {{$readonly}} >Enregistrer</button>
        <button type="submit" class="btn btn-primary" name = "btnSuivant" value="btnSuivant" >Suivant</button>
    {{Form::token()}}
   </form>

  </div>
</div>

<script>

  $(function(){

      $('#error').hide();

      $('#clickDiplome').click(function(){

        // variable qui servira à submit le formulaire ou pas
        var erreur = false;

        $('#error').hide();

          // On va tester l'année : il faut que ca soit un integer
          // On parcours alors tous les champs annees
          $('.annee').each(function(index) {

            var annee = $(this).val();

            // Champ vide : on laissera passé
            if(annee != ''){
              // Il faut que ça soit un integer
              if(annee != parseInt(annee) || annee.toString().length != 4){
                  $('#error').text('Vous devez renseigner des années correctes')
                  $('#error').show();
                  $('#succes').hide();
                  $('#errorServer').hide();
                  erreur = true;
                  return false;
              };
            }
          });

           // On va tester la moyenne : il faut que ca soit un integer
          // On parcours alors tous les champs annees
          $('.moyenne').each(function(index) {

            var moyenne = $(this).val();

            // Champ vide : on laissera passé
            if(moyenne != ''){
              // Il faut que ça soit un integer
              if(moyenne != parseInt(moyenne) || (moyenne < 0 || moyenne > 20)){
                  $('#error').text('Vous devez renseigner des moyennes correctes (entre 0 et 20)')
                  $('#error').show();
                  $('#succes').hide();
                  $('#errorServer').hide();
                  erreur = true;
                  return false;
              };
            }
          });

          if(erreur){
            return false;
          }else{
              $('#form').setAttrib('action','{{URL::route("diplome-post")}}');
              $('#form').submit();
          }
      });
  });

</script>

@stop