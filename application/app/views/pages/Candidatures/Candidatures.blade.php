@extends('template')

@section('content')

@include('workflow')

  @if(Session::has('message'))
    <p>{{Session::get('message')}}</p>
  @endif

  @if(Session::has('ErreurCandidature'))
    <p>{{Session::get('ErreurCandidature')}}</p>
  @endif

<div class="panel panel-default custom-panel">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body">

     @if(Session::has('succes'))
      <div class="alert alert-success custom-alert center" role="alert">{{Session::get('succes')}}</div>
    @endif

    @if(!empty($errors->all()))
      <div class="alert alert-danger custom-alert center" role="alert">
        Le formulaire comporte des erreurs
      </div>
    @endif

    <?php
        // Récupération de l'état de la candidature, si elle est envoyé, le formulaire ne sera plus éditable
        $readonly = '';
        if($candidature->etat_id == Constantes::ENVOYE 
                or $candidature->etat_id == Constantes::VALIDE or $candidature->etat_id == Constantes::REFUSE){
          $readonly = 'disabled';
        }

        $hidden = '';
        if($candidature->etat_id == Constantes::VALIDE){
          $hidden='style="display:none;"';
        }
    ?>

   <form id="form" action="{{URL::route('creationCandidature-post')}}" method="POST" class="form-horizontal inscription">

    <!-- Récupération de la page Candidature (premiere partie)   -->
    @include('pages.Candidatures.partieCandidature.partieCandidature')


    <div class="center" {{$hidden}}>
          <button id="clickCandidature" type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg" {{$readonly}} >Enregistrer</button>
         <button id="clickCandidature" type="submit" class="btn btn-primary" name = "btnSuiv" value="btnSuiv" >Suivant</button>
    </div>

{{Form::token()}}
 </form>

  </div>
</div>


<script>

  $(document).ready(function(){

        $('.datepicker').datepicker({
          language: 'fr'
        });
  });

</script>

@stop