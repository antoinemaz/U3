@extends('template')

@section('content')

  @if(Session::has('message'))
    <p>{{Session::get('message')}}</p>
  @endif

  @if(Session::has('ErreurCandidature'))
    <p>{{Session::get('ErreurCandidature')}}</p>
  @endif

<<<<<<< HEAD

 <?php print_r($errors)?>

=======
>>>>>>> f7ce38410a794d4272dfbf1f396b1cea8bae02b0
<div class="panel panel-default custom-panel">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body">

   <form action="{{URL::route('creationCandidature-post')}}" method="POST" class="form-horizontal inscription">

    
    <div class="form-group">
      <label for="InputDossierE">Dossier étrangé :</label>
      <input type="checkbox" name="InputDossierE" value="Oui"><br>
    </div>

    <div class="form-group">
      <label for="InputRegime">Régime d'inscription :</label>
          {{ Form::select('InputRegime', array($tabRegimeInscription),array('class' => 'form-control', 'placeholder' => '')) }}
    </div>

    <div class="form-group">
      <label for="InputNom">Nom :</label>
      {{ Form::text("InputNom", Input::get("InputNom"), array('class' => 'form-control', 'placeholder' => $candidature->nom)) }}
      @if($errors->has('InputNom'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputNom')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputPrenom">Prénom :</label>
      {{ Form::text("InputPrenom", Input::get("InputPrenom"), array('class' => 'form-control', 'placeholder' => $candidature->prenom)) }}
      @if($errors->has('InputPrenom'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputPrenom')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputDateNaissance">Date de naissance :</label>

      <input id="InputDateNaissance" class="datepicker" name ="InputDateNaissance" type="text">
      @if($errors->has('InputDateNaissance'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputDateNaissance')}}</div>
      @endif

    </div>

    <div class="form-group">
      <label for="InputLieu">Lieu de naissance :</label>
      {{ Form::text("InputLieu", Input::get("InputLieu"), array('class' => 'form-control', 'placeholder' => '')) }}
      @if($errors->has('InputLieu'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputLieu')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputSexe">Sexe :</label>
      {{ Form::select('InputSexe', array('masculin' => 'Masculin', 'F' => 'Féminin'),array('class' => 'form-control', 'placeholder' => $candidature->sexe)) }}
    </div>

    <div class="form-group">
      <label for="InputNatio">Nationalité :</label>
      <select name="InputNatio">
      <?php include 'C:\wamp\www\U3\application\app\views\pages\Candidatures\ListePays.php';?> 
    </div>

    <div class="form-group">
      <label for="InputTel">Téléphone :</label>
      {{ Form::text("InputTel", Input::get("InputTel"), array('class' => 'form-control', 'placeholder' => $candidature->telephone)) }}
      @if($errors->has('InputTel'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputTel')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputAdr">Adresse :</label>
      {{ Form::text("InputAdr", Input::get("InputAdr"), array('class' => 'form-control', 'placeholder' => $candidature->adresse)) }}
      @if($errors->has('InputAdr'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputAdr')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputVille">Ville :</label>
      {{ Form::text("InputVille", Input::get("InputVille"), array('class' => 'form-control', 'placeholder' => $candidature->Ville)) }}
      @if($errors->has('InputVille'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputVille')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputCP">Code postal :</label>
      {{ Form::text("InputCP", Input::get("InputCP"), array('class' => 'form-control', 'placeholder' => $candidature->codePostal)) }}
      @if($errors->has('InputCP'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputCP')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputPays">Pays :</label>
      <select name="InputPays">
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

    <button type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg" >Enregistrer</button>
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