    <?php

       $date_naissance = $candidature->date_naissance;
       $date_diplome = $candidature->date_dernier_diplome;

        if($date_naissance != null){
              
              if($date_naissance == '00/00/0000'){
                $date_naissance = null;
              }else{
                 $dateNaissanceSplite = explode("-", $date_naissance);
                 $date_naissance = $dateNaissanceSplite[2].'/'.$dateNaissanceSplite[1].'/'.$dateNaissanceSplite[0];
              }
            }

         if($date_diplome != null){
              
              if($date_diplome == '00/00/0000'){
                $date_diplome = null;
              }else{
                 $dateDiplomeSplite = explode("-", $date_diplome);
                 $date_diplome = $dateDiplomeSplite[2].'/'.$dateDiplomeSplite[1].'/'.$dateDiplomeSplite[0];
              }
            }
    ?>

    <div class="form-group">
      <label for="InputNom">Nom :</label>
      {{ Form::text("InputNom", $candidature->nom, array('class' => 'form-control', $readonly)) }}
      @if($errors->has('InputNom'))
        <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('InputNom')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputPrenom">Prénom :</label>
      {{ Form::text("InputPrenom", $candidature->prenom, array('class' => 'form-control', $readonly)) }}
      @if($errors->has('InputPrenom'))
        <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('InputPrenom')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputDateNaissance">Date de naissance :</label>

      {{ Form::text("InputDateNaissance", $date_naissance, array('class' => 'form-control datepicker', 'name' => 'InputDateNaissance', $readonly)) }}
      @if($errors->has('InputDateNaissance'))
        <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('InputDateNaissance')}}</div>
      @endif

    </div>

    <div class="form-group">
      <label for="InputLieu">Lieu de naissance :</label>
      {{ Form::text("InputLieu", $candidature->lieu_naissance, array('class' => 'form-control', $readonly)) }}
      @if($errors->has('InputLieu'))
        <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('InputLieu')}}</div>
      @endif
    </div>


     <div class="form-group">
      <label for="InputSexe">Sexe :</label>
       @foreach($tabSexe as $sexe)
            <?php
                if ($sexe != $candidature->sexe){
                  ?>
                    {{Form::radio('InputSexe', $sexe)}} {{$sexe}}
                  <?php }else{
                    ?> {{Form::radio('InputSexe', $sexe, true)}} {{$sexe}} <?php
                  }?>
      @endForeach

    </div>

    <div class="form-group">
      <label for="InputNatio">Nationalité :</label>

      <select name="InputNatio" class="form-control" {{$readonly}}>
            @foreach($tabPays as $pays)

              <?php
                if ($pays!=$candidature->nationalite){
                  ?> <option value="{{$pays}}">{{$pays}}</option> <?php
              }else{ ?>
                <option value="{{$pays}}" selected="selected">{{$pays}}</option> <?php
              } ?>
              
             @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="InputTel">Téléphone :</label>
      {{ Form::text("InputTel",  $candidature->telephone, array('class' => 'form-control', $readonly)) }}
      @if($errors->has('InputTel'))
        <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('InputTel')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputAdr">Adresse :</label>
      {{ Form::text("InputAdr", $candidature->adresse, array('class' => 'form-control', $readonly)) }}
      @if($errors->has('InputAdr'))
        <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('InputAdr')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputVille">Ville :</label>
      {{ Form::text("InputVille", $candidature->Ville, array('class' => 'form-control', $readonly)) }}
      @if($errors->has('InputVille'))
        <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('InputVille')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputCP">Code postal :</label>
      {{ Form::text("InputCP", $candidature->codePostal, array('class' => 'form-control', $readonly)) }}
      @if($errors->has('InputCP'))
        <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('InputCP')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputPays">Pays :</label>
            <select name="InputPays" class="form-control" {{$readonly}}>
            @foreach($tabPays as $pays)

              <?php
                if ($pays!=$candidature->Pays){
                  ?> <option value="{{$pays}}">{{$pays}}</option> <?php
              }else{ ?>
                <option value="{{$pays}}" selected="selected">{{$pays}}</option> <?php
              } ?>
              
             @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="InputDateDernDiplome">Date dernier diplôme :</label>

       {{ Form::text("InputDateDernDiplome", $date_diplome, array('class' => 'form-control datepicker', 'name' => 'InputDateDernDiplome', $readonly)) }}
       @if($errors->has('InputDateDernDiplome'))
        <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('InputDateDernDiplome')}}</div>
       @endif
    </div>

    <div class="form-group">
      <label for="InputAnnee">Année :</label>
        {{ Form::select('InputAnnee', $annee_convoitee, $candidature->annee_convoitee, array('class' => 'form-control', $readonly)) }}
    </div>

    <div class="form-group">
      <label for="InputFiliere">Fillière :</label>
        <div class="noBold">
          <!-- Dans ma liste $tabFiliere : Pour chaque filiere on l'affiche -->
          @foreach($tabFiliere as $unefiliere)
          <label for="InputFiliere">&nbsp;&nbsp;&nbsp;&nbsp;{{$unefiliere}} :</label>

          <?php
              $coche = false;

              // on va parcourir le tableau des filières de la candidature
              // Si on trouve une filière égale à une filière parmis le tableau de toutes les
              // filières, on coche la case
              foreach ($filieresCandidature as $key => $value) {
                   if ($unefiliere == $value) {
                    $coche = true;
                    break;
                  }   
              }
          ?>

          {{ Form::checkbox('filiere[]' , $unefiliere, $coche, ['name' => 'filiere[]',$readonly])}}
          @endforeach

          @if($errors->has('filiere'))
           <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('filiere')}}</div>
          @endif
        </div>
    </div>

    <div class="form-group">
      <label for="InputRegime">Régime d'inscription :</label>
          <select name="InputRegime" class="form-control" {{$readonly}}>
            @foreach($tabRegimeInscription as $unRegime)

              <?php
                if($candidature->regime_inscription == $unRegime){
                    ?>
                    <option value="{{$unRegime}}" selected="selected">{{$unRegime}}</option>  
                    <?php
                }else{
                    ?>
                  <option value="{{$unRegime}}" >{{$unRegime}}</option>
                  <?php
                }
              ?>
             @endforeach
          </select>
    </div>

    <div class="form-group">
      <label for="InputDossierE">Dossier étrangé :</label>
      <?php
        $checked = '';
        if ($candidature->dossier_etrange == 1){
          $checked = 'checked';
        }
      ?>
      <input type="checkbox" name="InputDossierE" value="1" {{$checked}} {{$readonly}} ><br>
    </div>