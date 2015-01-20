@if($errors->has('annee'))
  <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('annee')}}</div>
@endif
@if($errors->has('moyenne_annee'))
  <div class="alert alert-danger custom-alert" role="alert">{{$errors->first('moyenne_annee')}}</div>
@endif
  
    <div class="table-responsive">
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
                <div style="width: 80px;">
                  <p style="display: inline-block;width: 45px;">BAC + </p>
                   <input type="text" maxlength="1" class="form-control bac" style="display: inline-block;padding: 4px;width: 19px;" name="bac[]" value="{{ $diplome->numero}}" {{$readonly}} />
                </div>
            </td>
            <td>
              <input type="text" maxlength="4" class="form-control annee" style="width:70px;" name="annee[]" value="{{ $diplome->annee}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="100" class="form-control" style="width:160px;" name="etablissement[]" value="{{ $diplome->etablissement}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="100" class="form-control" style="width:160px;" name="diplome[]" value="{{ $diplome->diplome}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="2" class="form-control moyenne" style="width:70px;" name="moyenne_annee[]" value="{{ $diplome->moyenne_annee}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="100" class="form-control" style="width:160px;" name="mention[]" value="{{ $diplome->mention}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="100" class="form-control" style="width:70px;" name="rang[]" value="{{ $diplome->rang}}" {{$readonly}} />
            </td>
          </tr>
          @endForeach
        </tbody>
    </table>
  </div>