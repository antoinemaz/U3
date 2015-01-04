@if($errors->has('date_debut'))
  <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('date_debut')}}</div>
@endif
@if($errors->has('date_fin'))
  <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('date_fin')}}</div>
@endif

    <div class="table-responsive">
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
                <input type="text"class="datepickerDeb form-control mydate" style="width:90px;" name="date_debut[]" 
                  value="{{ $date_debut }}" {{$readonly}} />
                  
              </td>
              <td>
                <input type="text" class="datepickerFin form-control mydate" style="width:90px;" name="date_fin[]" 
                    value="{{ $date_fin }}" {{$readonly}} />
              </td>
              <td>
                <input maxlength="100" type="text" class="form-control" style="width:160px;" name="nom[]" value="{{ $stage->nom}}" {{$readonly}} />
              </td>
              <td>
                <input maxlength="100" type="text" class="form-control" style="width:160px;" name="adresse[]" value="{{ $stage->adresse}}" {{$readonly}} />
              </td>
               <td>
                <textarea maxlength="400" class="form-control travailStage" name="travail_effectue[]" {{$readonly}} >{{ $stage->travail_effectue}}</textarea>
              </td>
            </tr>
            @endForeach
          </tbody>
      </table>
    </div>

    {{Form::token()}}