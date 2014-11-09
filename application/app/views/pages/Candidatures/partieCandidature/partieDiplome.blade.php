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
              <input type="text" maxlength="4" class="form-control annee" style="width:70px;" name="annee[]" value="{{ $diplome->annee}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="200" class="form-control" style="width:160px;" name="etablissement[]" value="{{ $diplome->etablissement}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="200" class="form-control" style="width:160px;" name="diplome[]" value="{{ $diplome->diplome}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="2" class="form-control moyenne" style="width:70px;" name="moyenne_annee[]" value="{{ $diplome->moyenne_annee}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="200" class="form-control" style="width:160px;" name="mention[]" value="{{ $diplome->mention}}" {{$readonly}} />
            </td>
            <td>
              <input type="text" maxlength="200" class="form-control" style="width:70px;" name="rang[]" value="{{ $diplome->rang}}" {{$readonly}} />
            </td>
          </tr>
          @endForeach
        </tbody>
    </table>