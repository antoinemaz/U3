@extends('template')

@section('content')

       <script type="text/javascript">
      window.onload = function (){

        <?php

          $count = 0;

          foreach ($pieces as $key => $value) {
            $count++;
            ?>
            // Javascript : instance d'un objet PDFObject pour l'affichage du PDF dans la page
            var myPDF = new PDFObject({ url: 'uploads/<?php echo $value->uid ?>' })
            .embed('pdf'+<?php echo $count;  ?> );
            <?php
          }

        ?>

      };
    </script>

    <?php

      for ($i=1; $i <= $count ; $i++) { 
         ?>
          <div id="pdf{{$i}}"></div>
         <?php
      }
    ?>
    
    <form action="{{URL::route('diplome-post')}}" method="POST" class="form-horizontal">

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
              <input type="text" class="form-control" style="width:70px;" name="annee[]" value="{{ $diplome->annee}}"/>
            </td>
            <td>
              <input type="text" class="form-control" style="width:160px;" name="etablissement[]" value="{{ $diplome->etablissement}}"/>
            </td>
            <td>
              <input type="text" class="form-control" style="width:160px;" name="diplome[]" value="{{ $diplome->diplome}}"/>
            </td>
            <td>
              <input type="text" class="form-control" style="width:70px;" name="moyenne_annee[]" value="{{ $diplome->moyenne_annee}}"/>
            </td>
            <td>
              <input type="text" class="form-control" style="width:160px;" name="mention[]" value="{{ $diplome->mention}}"/>
            </td>
            <td>
              <input type="text" class="form-control" style="width:70px;" name="rang[]" value="{{ $diplome->rang}}"/>
            </td>
          </tr>
          @endForeach
        </tbody>
    </table>

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
    <button type="submit" class="btn btn-primary">Enregistrer</button>

  </form>

      <script>
        $(document).ready(function(){

          $('.datepicker').datepicker({
            language: 'fr'
          });
        });
      </script>
@stop