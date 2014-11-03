@extends('template')

@section('content')

  @if(Session::has('message'))
    <p>{{Session::get('message')}}</p>
  @endif

  @if(Session::has('ErreurCandidature'))
    <p>{{Session::get('ErreurCandidature')}}</p>
  @endif

 <!--<?php print_r($errors)?>-->

 <?php

 $idUser = Auth::user()->id;
 $candidature = Candidature::where('utilisateur_id', '=', $idUser);

 if($candidature->count()){
        $candidature = $candidature->first(); 

        if($candidature->etat_id == 2){

            $etat = 'disabled';
        

        }else{

            $etat = "";

        }

 }


 ?>


<div class="panel panel-default custom-panel">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body">

   <form action="{{URL::route('creationCandidature-post')}}" method="POST" class="form-horizontal inscription">

    
    <div class="form-group">
      <label for="InputDossierE" >Dossier étrangé :</label>
      <input type="checkbox" name="InputDossierE" value="Oui" {{$etat}}><br>
    </div>

    <div class="form-group">
      <label for="InputRegime">Régime d'inscription :</label>
          {{ Form::select('InputRegime', array($tabRegimeInscription),array('class' => 'form-control', 'placeholder' => $candidature->dossier_etrange, 'disabled' => $etat)) }}
    </div>

    <div class="form-group">
      <label for="InputNom">Nom :</label>
      {{ Form::text("InputNom", Input::get("InputNom"), array('class' => 'form-control', 'placeholder' => $candidature->nom, $etat)) }}
      @if($errors->has('InputNom'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputNom')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputPrenom">Prénom :</label>
      {{ Form::text("InputPrenom", Input::get("InputPrenom"), array('class' => 'form-control', 'placeholder' => $candidature->prenom, $etat)) }}
      @if($errors->has('InputPrenom'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputPrenom')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputSexe">Sexe :</label>
      <!--disabled={{$etat}} -->
      <select name="InputSexe"  >
        @if($candidature->sexe == 'Feminin')
        {{print ($candidature->sexe);}}
        <option value="Masculin">Masculin </option>
        <option value="Feminin"  selected="selected" >Feminin </option>
        @endif

      </select>
    </div>

    <div class="form-group">
      <label for="InputDateNaissance">Date de naissance :</label>

      <input id="InputDateNaissance" class="datepicker" name ="InputDateNaissance" type="text" placeholder= {{$candidature->date_naissance}}>
      @if($errors->has('InputDateNaissance'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputDateNaissance')}}</div>
      @endif

    </div>

    <div class="form-group">
      <label for="InputLieu">Lieu de naissance :</label>
      {{ Form::text("InputLieu", Input::get("InputLieu"), array('class' => 'form-control', 'placeholder' => $candidature->lieu_naissance, $etat)) }}
      @if($errors->has('InputLieu'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputLieu')}}</div>
      @endif
    </div>


    <div class="form-group">
      <label for="InputNatio">Nationalité :</label>
      <select name="InputNatio" disabled={{$etat}}>
      <?php include 'C:\wamp\www\U3\application\app\views\pages\Candidatures\ListePays.php';?> 
    </div>

    <div class="form-group">
      <label for="InputTel">Téléphone :</label>
      {{ Form::text("InputTel", Input::get("InputTel"), array('class' => 'form-control', 'placeholder' => $candidature->telephone, $etat)) }}
      @if($errors->has('InputTel'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputTel')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputAdr">Adresse :</label>
      {{ Form::text("InputAdr", Input::get("InputAdr"), array('class' => 'form-control', 'placeholder' => $candidature->adresse, $etat)) }}
      @if($errors->has('InputAdr'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputAdr')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputVille">Ville :</label>
      {{ Form::text("InputVille", Input::get("InputVille"), array('class' => 'form-control', 'placeholder' => $candidature->Ville, $etat)) }}
      @if($errors->has('InputVille'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputVille')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputCP">Code postal :</label>
      {{ Form::text("InputCP", Input::get("InputCP"), array('class' => 'form-control', 'placeholder' => $candidature->codePostal, $etat)) }}
      @if($errors->has('InputCP'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputCP')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputPays">Pays :</label>
      <select name="InputPays" disabled={{$etat}}>
      <?php include 'C:\wamp\www\U3\application\app\views\pages\Candidatures\ListePays.php';?> 
    </div>

    <div class="form-group">
      <label for="InputFiliere">Fillière :</label>
        <div class="form-group">
          <!-- Dans ma liste $tabFiliere : Pour chaque filiere on l'affiche -->
          @foreach($tabFiliere as $unefiliere)
          <label for="InputFiliere">&nbsp;&nbsp;&nbsp;&nbsp;{{$unefiliere}} :</label>
          {{ Form::checkbox('filiere[]' , $unefiliere)}}
          @endforeach

        </div>
    </div>

    <div class="form-group">
      <label for="InputDateDernDiplome">Date dernier diplôme :</label>

       <input id="InputDateDernDiplome" name ="InputDateDernDiplome" class="datepicker" type="text">
       @if($errors->has('InputDateDernDiplome'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputDateDernDiplome')}}</div>
       @endif


    </div>

    <button type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg" {{$etat}} >Enregistrer</button>
    <button type="submit" class="btn btn-primary" name = "btnValid" value="btnValid" >Valider</button>

  

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