@extends('template')

@section('content')

@include('workflow')

<div class="panel panel-default custom-panel" style="max-width:980px;">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body">

    @if(Session::has('succes'))
      <div id="succes" class="alert alert-success custom-alert center" role="alert">{{Session::get('succes')}}</div>
    @endif

    <div id="error" class="alert alert-danger custom-alert center" role="alert"></div>

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

    <form id="form" action="{{URL::route('stage-post')}}" method="POST" class="form-horizontal"  style="text-align:center;">

        @include('pages.Candidatures.partieCandidature.partieStage')

        <button type="submit" class="btn btn-primary" name = "btnPrecedent" value="btnPrecedent" >Précédent</button>
        <button id="clickStage" type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg" {{$readonly}} >Enregistrer</button>
        <button type="submit" class="btn btn-primary" name = "btnSuivant" value="btnSuivant" >Suivant</button>

  </form>

    </div>
</div>

<script>

     $(function(){

      $('#error').hide();

       var dateDDMMYYYRegex = '^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)dd$';

        $('#clickStage').click(function(){

          // variable qui servira à submit le formulaire ou pas
          var erreur = false;

          $('#error').hide();

            // On va tester les dates
            $('.mydate').each(function(index) {

              var date = $(this).val();

              if(date != ''){

                // Champ vide : on laissera passé
                if(!date.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/)){
                      $('#error').text('Vous devez renseigner des dates correctes')
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