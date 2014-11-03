@extends('template')

@section('content')

@include('workflow')

<div class="panel panel-default custom-panel">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body" style="text-align: center;line-height: 26px;">

      <?php
        if ($etat == 2){
          ?>
            Votre candidature a été envoyée. Un mail vous sera envoyé en cas de changement d'état de votre candidature
          <?php
        }else{
          ?>
                Vous avez terminé de remplir votre candidature. Toutes les informations ont été enregistrées. <br/>
                Si vous validez votre candidature, elle sera envoyée et vous ne pourrez plus la modifier. <br/>
                <form action="{{URL::route('finalisation-post')}}" method="POST">
                   <button style="margin-top: 10px;" type="submit" class="btn btn-primary" 
                   name = "btnEnreg" value="btnEnreg" >Valider la candidature</button>
                   {{Form::token()}}
               </form>
          <?php
        }
      ?>
    </div>
</div>
@stop