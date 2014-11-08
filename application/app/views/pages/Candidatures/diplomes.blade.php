@extends('template')

@section('content')

@include('workflow')

<div class="panel panel-default custom-panel">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body">

    <form action="{{URL::route('diplome-post')}}" id="form" method="POST" class="form-horizontal" style="text-align:center;">

        <div id="error" class="alert alert-danger custom-danger" role="alert">{{Session::get('customError')}}</div>
      
      <table id="diplomes" class="table datatable tableOfCandidature" style="margin:0 auto;">
        <thead>
          <tr>
            <th>Libellé</th>
            <th>Année</th>
            <th>Etablissement</th>
            <th>Diplome</th>
            <th>Moyenne annuelle</th>
            <th>Mention</th>
            <th>Rang</th>
          </tr>
        </thead>

          <tbody>
          @foreach($diplomes as $diplome)
          <tr>
            <td>
              <p style="width:60px;margin-bottom: 8px;margin-top: 8px;">BAC 
                <?php 
                  // Si le numéro est égal à 1, cela équivaut au niveau BAC
                  if($diplome->numero == 1){ 
                    Print("");
                  }else{  
                    // sinon c'est de BAC+1 à BAC+5
                    Print(" +"). ($diplome->numero - 1); 
                  }
                ?></p>
            </td>
            <td>
              <!-- {{ Form::text("annee[$diplome->numero]", Input::get("annee[$diplome->numero]"), array('class' => 'form-control')) }} -->
              <input type="text" maxlength="4" class="form-control annee" style="width:70px;" name="annee[]" value="{{ $diplome->annee}}"/>
            </td>
            <td>
              <input type="text" maxlength="200" class="form-control" style="width:160px;" name="etablissement[]" value="{{ $diplome->etablissement}}"/>
            </td>
            <td>
              <input type="text" maxlength="200" class="form-control" style="width:160px;" name="diplome[]" value="{{ $diplome->diplome}}"/>
            </td>
            <td>
              <input type="text" maxlength="2" class="form-control moyenne" style="width:70px;" name="moyenne_annee[]" value="{{ $diplome->moyenne_annee}}"/>
            </td>
            <td>
              <input type="text" maxlength="200" class="form-control" style="width:160px;" name="mention[]" value="{{ $diplome->mention}}"/>
            </td>
            <td>
              <input type="text" maxlength="200" class="form-control" style="width:70px;" name="rang[]" value="{{ $diplome->rang}}"/>
            </td>
          </tr>
          @endForeach
        </tbody>
    </table>
        <button type="submit" class="btn btn-primary" name = "btnPrecedent" value="btnPrecedent" >Précédent</button>
        <button id="clickDiplome" type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg" >Suivant</button>
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
              if(annee != parseInt(annee)){
                  $('#error').text('Vous devez renseigner des années correctes')
                  $('#error').show();
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
              if(moyenne != parseInt(moyenne)){
                  $('#error').text('Vous devez renseigner des moyennes correctes')
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

</script>

@stop