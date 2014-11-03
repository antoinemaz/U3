@extends('template')

@section('content')

@include('workflow')

<div class="panel panel-default custom-panel">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body">

    <form action="{{URL::route('stage-post')}}" method="POST" class="form-horizontal"  style="text-align:center;">

      @if($errors->has('date_debut'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('date_debut')}}</div>
      @endif
    <table id="stages" class="table datatable tableOfCandidature" style="margin:0 auto;">
        <thead>
          <tr>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Nom de l'entreprise</th>
            <th>Adresse</th>
            <th>Travail effectué</th>
          </tr>
        </thead>

          <tbody>
          @foreach($stages as $stage)

          <?php

            $date_debut = null;
            $date_fin = null;

            if($stage->date_debut != null){
              
              if($date_debut == '00/00/0000'){
                $date_debut = null;
              }else{
                 $dateDebutSplite = explode("-", $stage->date_debut);
                 $date_debut = $dateDebutSplite[2].'/'.$dateDebutSplite[1].'/'.$dateDebutSplite[0];
              }
            }

            if($stage->date_fin != null){

              if($date_fin == '00/00/0000'){
                  $date_fin = null;
              }else{
                  $dateFinSplite = explode("-", $stage->date_debut);
                  $date_fin = $dateFinSplite[2].'/'.$dateFinSplite[1].'/'.$dateFinSplite[0];
              }
            }
          ?>

          <tr>
            <td>
              <input type="text"class="datepicker form-control" style="width:160px;" name="date_debut[]" 
                value="{{ $date_debut }}"/>
                
            </td>
            <td>
              <input type="text" class="datepicker form-control" style="width:160px;" name="date_fin[]" 
                  value="{{ $date_fin }}"/>
            </td>
            <td>
              <input type="text" class="form-control" style="width:160px;" name="nom[]" value="{{ $stage->nom}}"/>
            </td>
            <td>
              <input type="text" class="form-control" style="width:70px;" name="adresse[]" value="{{ $stage->adresse}}"/>
            </td>
             <td>
              <input type="text" class="form-control" style="width:70px;" name="travail_effectue[]" value="{{ $stage->travail_effectue}}"/>
            </td>
          </tr>
          @endForeach
        </tbody>
    </table>

    {{Form::token()}}
        <button type="submit" class="btn btn-primary" name = "btnPrecedent" value="btnPrecedent" >Précédent</button>
        <button type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg" >Suivant</button>

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