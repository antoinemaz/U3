@extends('template')

@section('content')

  @if(Session::has('message'))
    <p>{{Session::get('message')}}</p>
  @endif

  @if(Session::has('ErreurCandidature'))
    <p>{{Session::get('ErreurCandidature')}}</p>
  @endif


<div class="panel panel-default custom-panel">
    <div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Formulaire de candidature</div>
    <div class="panel-body">

   <form action="{{URL::route('creationCandidature-post')}}" method="POST" class="form-horizontal inscription">

    <div class="form-group">
      <label for="InputNom">Nom :</label>
      {{ Form::text("InputNom", Input::get("InputNom"), array('class' => 'form-control', 'placeholder' => $candidature->nom , 'disabled')) }}
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
      <label for="InputAnnee">Date de naissance :</label>
      {{ Form::text("InputAnnee", Input::get("InputAnnee"), array('class' => 'form-control', 'placeholder' => '','data-datepicker' => 'datepicker')) }}

      <!-- {{ Form::text('date', null, array('type' => 'text', 'class' => 'form-control datepicker','placeholder' => 'Pick the date this task should be completed', 'id' => 'calendar')) }} -->

      @if($errors->has('InputAnnee'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputAnnee')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputSexe">Sexe :</label>
      {{ Form::select('InputSexe', array('masculin' => 'feminin', 'F' => 'Féminin'),array('class' => 'form-control', 'placeholder' => $candidature->sexe)) }}
      @if($errors->has('InputSexe'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputSexe')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputNatio">Nationalité :</label>
      {{ Form::text("InputNatio", Input::get("InputNatio"), array('class' => 'form-control', 'placeholder' => $candidature->nationalite)) }}
      @if($errors->has('InputNatio'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputNatio')}}</div>
      @endif
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
      <label for="InputDernDip">Dernier diplôme :</label>
      {{ Form::text("InputDernDip", Input::get("InputDernDip"), array('class' => 'form-control', 'placeholder' => $candidature->dernier_diplome)) }}
      @if($errors->has('InputDernDip'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputDernDip')}}</div>
      @endif
    </div>

    <div class="form-group">
      <label for="InputAnneeDernDip">Année dernier diplôme :</label>
      {{ Form::text("InputAnneeDernDip", Input::get("InputAnneeDernDip"), array('class' => 'form-control', 'placeholder' => $candidature->annee_dernier_diplome)) }}
      @if($errors->has('InputAnneeDernDip'))
        <div class="alert alert-danger custom-danger" role="alert">{{$errors->first('InputAnneeDernDip')}}</div>
      @endif
    </div>


    <button type="submit" class="btn btn-primary" name = "btnEnreg" value="btnEnreg" >Enregistrer</button>
    <button type="submit" class="btn btn-primary" name = "btnValid" value="btnValid" >Valider</button>

  

{{Form::token()}}
 </form>

  </div>
</div>



@stop