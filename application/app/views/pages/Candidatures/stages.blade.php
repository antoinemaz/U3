@extends('template')

@section('content')

@include('workflow')

<div class="panel panel-default custom-panel" style="max-width:980px;">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body">

    <form id="form" action="{{URL::route('stage-post')}}" method="POST" class="form-horizontal"  style="text-align:center;">

        <div class="alert alert-danger custom-danger" id="error" role="alert"></div>

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
                  $dateFinSplite = explode("-", $stage->date_fin);
                  $date_fin = $dateFinSplite[2].'/'.$dateFinSplite[1].'/'.$dateFinSplite[0];
              }
            }
          ?>

          <tr>
            <td>
              <input type="text"class="datepicker form-control mydate" style="width:90px;" name="date_debut[]" 
                value="{{ $date_debut }}"/>
                
            </td>
            <td>
              <input type="text" class="datepicker form-control mydate" style="width:90px;" name="date_fin[]" 
                  value="{{ $date_fin }}"/>
            </td>
            <td>
              <input maxlength="200" type="text" class="form-control" style="width:160px;" name="nom[]" value="{{ $stage->nom}}"/>
            </td>
            <td>
              <input maxlength="200" type="text" class="form-control" style="width:160px;" name="adresse[]" value="{{ $stage->adresse}}"/>
            </td>
             <td>
              <textarea maxlength="200" class="form-control travailStage" name="travail_effectue[]">{{ $stage->travail_effectue}}</textarea>
            </td>
          </tr>
          @endForeach
        </tbody>
    </table>

    {{Form::token()}}
        <button type="submit" class="btn btn-primary" name = "btnPrecedent" value="btnPrecedent" >Précédent</button>
        <button id="clickStage" type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg" >Suivant</button>

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

      $('.datepicker').datepicker({
        language: 'fr'
      });
    });

</script>

@stop