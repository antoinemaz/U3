@extends('template')

@section('content')

@include('workflow')

@if(Session::has('candidature-incomplete'))
    <div class="alert alert-danger custom-alert center" role="alert">
      {{Session::get('candidature-incomplete')}}
    </div>
@endIf

<div class="panel panel-default custom-panel">
    <div class="panel-heading"> <span class="glyphicon glyphicon-share"></span> Finalisation</div>
    <div class="panel-body" style="text-align: center;line-height: 26px;">

      @if($candidature->complet == 0)
        Vous devez remplir toutes les informations nécéssaires afin que l'on puisse traiter votre candidature
      @else
        @if($candidature->etat_id == Constantes::ENVOYE)
            Votre candidature a été envoyée. Un mail vous sera envoyé en cas de changement d'état de votre candidature
        @else
                Vous avez terminé de remplir votre candidature. Toutes les informations ont été enregistrées. <br/>
                Si vous validez votre candidature, elle sera envoyée et vous ne pourrez plus la modifier. <br/>
                <form action="{{URL::route('finalisation-post')}}" method="POST">
                 {{Form::token()}}

                 <button style="margin-top: 10px;" type="button" class="btn btn-primary" 
                 data-toggle="modal" data-target=".confirmerEnvoi" >Envoyer la candidature</button>

                 <!-- Fenetre modale qui s'ouvre pour confirmer l'envoi de la candidature  -->
                 <div class="modal fade confirmerEnvoi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm" style="margin-top: 270px;">
                    <div class="modal-content" style="padding: 10px;">
                      Etes-vous sûr ?
                      <button  type="submit" class="btn btn-primary" 
                      name = "btnEnreg" value="btnEnreg" >Oui</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                    </div>
                  </div>
                </div>

              </form>
        @endif
      @endif
    </div>
</div>

<script>



</script>

@stop