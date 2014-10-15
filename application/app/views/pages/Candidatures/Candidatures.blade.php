@extends('template')

@section('content')

	<H1> Formulaire de candidature </H1>

<!--
@foreach ($etudiants as $etudiant)
	<h2>{{ $etudiant->nom }}</h2>
	<p>{{ $etudiant->prenom }}</p>
@endforeach

-->


<!-- La balise form va utiliser automatiquement le post au niveau des routes */

Action sur bouton, apelation de la route correspondante pour use la methode du controleur createincident -->

{{ Form::open(array('url' => '/', 'role' => 'form')) }}


<form role="form">
  <div class="form-group">
    <label for="InputNom">Nom :</label>
    <input type="text" class="form-control" id="InputNom" placeholder="Entrer votre nom">
  </div>
  <div class="form-group">
    <label for="InputPrenom">Prénom :</label>
    <input type="text" class="form-control" id="InputPrenom" placeholder="Entrer votre prénom">
  </div>
  <div class="form-group">
    <label for="InputAnnee">Année de naissance :</label>
    <input type="text" class="form-control" id="InputAnnee" placeholder="Entrer votre date de naissance">
  </div>
  <div class="form-group">
    <label for="InputSexe">Sexe :</label>
    <input type="text" class="form-control" id="InputSexe" placeholder="Entrer votre date de naissance">
  </div>
  <div class="form-group">
    <label for="InputNatio">Nationalité :</label>
    <input type="text" class="form-control" id="InputNatio" placeholder="Entrer votre date de naissance">
  </div>
  <div class="form-group">
    <label for="InputTel">Téléphone :</label>
    <input type="text" class="form-control" id="InputTel" placeholder="Entrer votre téléphone">
  </div>
  <div class="form-group">
    <label for="InputAdr">Adresse :</label>
    <input type="text" class="form-control" id="InputAdr" placeholder="Entrer votre adresse">
  </div>
  <div class="form-group">
    <label for="InputCP">Code postal :</label>
    <input type="text" class="form-control" id="InputCP" placeholder="Entrer votre code postal">
  </div>
  <div class="form-group">
    <label for="InputDernDip">Dernier diplôme :</label>
    <input type="text" class="form-control" id="InputDernDip" placeholder="Entrer l'intitulé de votre dernier diplôme">
  </div>
  <div class="form-group">
    <label for="InputAnneeDernDip">Année dernier diplôme :</label>
    <input type="text" class="form-control" id="InputAnneeDernDip" placeholder="Entrer l'année d'obtention de votre dernier diplôme">
  </div>

  <form class="form-inline" role="form">
  <div class="form-group">
    <label class="sr-only" for="InputMail">Adresse email :</label>
    <input type="email" class="form-control" id="InputMail" placeholder="Entrer votre adresse email">
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">@</div>
      <input class="form-control" type="email" placeholder="Enter email">
    </div>
  </div>
  <div class="form-group">
    <label class="sr-only" for="exampleInputPassword2">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
  </div>
  </form>


  <button type="submit" class="btn btn-default">Enregistrer</button>
</form>

<!--

Exemple de creation de formulaire sans utiliser bootstrap, seulement avec php

<table>
<tr>
	<td>
	{{ Form::label('nom', 'Nom :') }}
		{{ Form::text('nom', '') }}
	</td>
</tr>
<tr>
	<td>
	{{ Form::label('red_id', 'Redmine id :') }}
		{{ Form::text('red_id', '') }}
	</td>
</tr>
<tr>
	<td>
{{ Form::submit('Enregistrer')}}
</td>
</tr>

</table>

-->

{{ Form::close() }}
	

	
@stop