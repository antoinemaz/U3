@extends('template')

@section('content')

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
              <input type="text" class="form-control" style="width:160px;" name="libelle[]" value="{{ $diplome->libelle}}"/>
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
              <input type="text" class="form-control" style="width:70px;" name="moyenne[]" value="{{ $diplome->moyenne_annee}}"/>
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
    {{Form::token()}}
    <button type="submit" class="btn btn-primary">Enregistrer</button>

  </form>
@stop