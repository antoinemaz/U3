<?php 

class ConfigurationController extends BaseController {


    public function getConfiguration(){

      // Récupération des gestionnaires et des admins
      $gestionnairesAndAdmins = DB::table('utilisateurs')
      ->where('role_id', Constantes::GESTIONNAIRE)->orWhere('role_id', Constantes::ADMINISTRATEUR)->get();

      // Récupération des roles (sauf étudiants)
      $tabRoles = DB::table('roles')->whereNotIn('id', array(Constantes::ETUDIANT))->get();

      // Récupération de la valeur de la config sendMailsToGestionnaires
      $properties = $this->getValueOfConfiguration();

      //Tableau temporaire à remplacer par ce que l'on réupère dans redmine
      $tabFilliere = ["MIAGE","MIAGE App","ASR","Info","FC"];

      $annee_convoitee[2] = ('Année L2');
      $annee_convoitee[3] = 'Année L3';
      $annee_convoitee[4] = 'Année M1';
      $annee_convoitee[5] = 'Année M2';
      $annee_convoitee[6] = 'Information sur le site';

      //Récupération dans la table associative des couples Année/Fillière du user courant
       $coupleAnneeFilliere= DB::table('correspondances')
      ->where('utilisateur_id', Auth::user()->id)->get();

      return View::make('pages.gestion.configuration')
      ->with(array('properties' => $properties, 'gestionnairesAndAdmins' => $gestionnairesAndAdmins, 
        'tabRoles' => $tabRoles, 'tabFiliere' => $tabFilliere, 'coupleAnneeFilliere' => $coupleAnneeFilliere, 
        'annee_convoitee' => $annee_convoitee));
    }

    // Suppression des données
    public function getConfirmationSuppression(){
      return View::make('pages.gestion.confirmationSuppression');
    }

    public function postConfiguration(){

      // On purge les candidature
      if(Input::get('btnDelete')){
        // Page de confirmation de la suppression des données
        return Redirect::route('deleteDonnees');
  
      // On sauvegarder les configurations
     }else{

        $validator = Validator::make(Input::all(),
          array('date_deb' => 'date_format:d/m/Y',
            'date_fin' => 'date_format:d/m/Y'));

        // Si la validation échoue, on redirige vers la même page avec les erreurs
        if($validator->fails()){
            return Redirect::route('configuration-get')->with('configuration-erreur_date', 'Format de date incorrect')
            ->withErrors($validator)
            ->withInput();
        }else{
              // On set les valeurs de configuration
            $value = $this->getValueOfConfiguration();
            $value->active = Input::get('sendMailsGestionnaires');

              // Traitement de la date de début de période 
            if(Input::get('date_deb') != ''){
              $dateDebSplite = explode("/", Input::get('date_deb'));
              $dateDeb = $dateDebSplite[2].'-'.$dateDebSplite[1].'-'.$dateDebSplite[0];
            }else{
              $dateDeb = null;
            }
              // Traitement de la date de fin de période
            if(Input::get('date_fin') != ''){
              $dateFinSplite = explode("/", Input::get('date_fin'));
              $dateFin = $dateFinSplite[2].'-'.$dateFinSplite[1].'-'.$dateFinSplite[0];
            }else{
              $dateFin = null;
            }


            $value->date_debut_periode = $dateDeb;
            $value->date_fin_periode = $dateFin;

            if($value->save()){
              return Redirect::route('configuration-get')->with('configuration-enregistre', 'Configuration enregistrée');
            }
        }
    }
  }

  public function getValueOfConfiguration(){
      // On va récupérer la seule occurence dans la table configuration qui contient toutes les propriétés
    $properties = Configuration::where('id', '=', 1);

    if($properties->count()){ 
     $properties = $properties->first(); 
     return $properties;
   }
   return null;
 }

   public function postCreateCompteGestionnaire()
   {
    $validator = Validator::make(Input::all(),
      array('email' => 'required|max:50|email|unique:utilisateurs',
        'role' => 'numeric|regex:/^[2-3]{1}$/'));

          // Si la validation échoue, on redirige vers la même page avec les erreurs
    if($validator->fails()){
      return Redirect::route('configuration-get')
      ->withErrors($validator)
      ->withInput();
    }else{

            // on set les valeurs des inputs dans des variables
      $email = Input::get('email');
      $role = Input::get('role');

            // code d'activation et password 
      $code = str_random(60);
      $password = str_random(10);

            // Enregistrement en base de données
      $create = Utilisateur::create(array(
        'email' => $email,
        'password' => Hash::make($password),
        'code' => $code,
        'active' => 0,
        'role_id' => $role
        ));

      if($create){

        // Envoi du mail au gestionnaire

        $libelleRole=null;
        if($create->role_id == Constantes::GESTIONNAIRE){
          $libelleRole="Gestionnaire";
        }else{
          $libelleRole = "Administrateur";
        }

        $mailService = new MailService();
        $mailService->sendMailCompteGestionnaire($create, $libelleRole, $code, $password);

        // On redirige vers la page d'accueil
        return Redirect::route('configuration-get')
        ->with('gestionnaire-cree', 'Compte créé');
      }
    }
  }



    public function postAddCoupleAnneeFilliere()
   {

      $annee = Input::get('annee');
      $filliere = Input::get('filliere');

      $idUser = Auth::user()->id;

      //Insert Bdd
      $create = Correspondance::create(array(
        'utilisateur_id' => $idUser,
        'filiere_resp' =>  $filliere,
        'annee_resp' => $annee,
        ));

      if($create){

        //Redirection page configuration
        return Redirect::route('configuration-get')
        ->with('CoupleAnneeFilliere-add', 'Couple Année/Filliere ajouté !');
      }else{

        return Redirect::route('configuration-get')
        ->with('CoupleAnneeFilliere-add', 'Une erreur s est produite lors de l ajout du couple !');

      }
    }




  public function deleteGestionnaire($id){

          // Le premier utilisateur administrateur est impossible à supprimer
    if($id == 1){
      return Redirect::route('configuration-get');
    }else{
      $gestionnaire = Utilisateur::where('role_id', '=', Constantes::GESTIONNAIRE)
      ->orWhere('role_id', Constantes::ADMINISTRATEUR)->where('id', '=', $id);

      if($gestionnaire->count()){
        $gestionnaire = $gestionnaire->first();
        $gestionnaire->delete();

        return Redirect::route('configuration-get')
        ->with('gestionnaire-supprime', 'Le compte a été supprimé');

      }else{
        return Redirect::route('configuration-get');
      }
    }
  }


  public function deleteCouple($id){

    $couple = Correspondance::where('id', '=', $id);

    if($couple->count()){
      $couple = $couple->first();

      $couple->delete();

      return Redirect::route('configuration-get')
      ->with('CoupleAnneeFilliere-supprime', 'Le couple a été supprimé');

    }else{
      return Redirect::route('configuration-get');
    }

  }

  public function postSuppression(){

    // Obtention du password tapé dans le champ
    $passwordInput = Input::get('password');

    // Si on est admin et que le mot de passe est bon, ok on supprime
    if(Auth::user()->role_id == Constantes::ADMINISTRATEUR and Hash::check($passwordInput, Auth::user()->password)){
         
          // On rentre dans une transaction
         DB::transaction(function(){
           // Suppression de tous les diplomes
           $diplomes = DB::table('diplomes')->delete();

           // Suppression de tous les stages
           $stages = DB::table('stages')->delete();

           // Suppression de toutes les pièces jointes dans le file system
           $deletefile = File::deleteDirectory('uploads/', true);

           if($deletefile){
              // Suppression de tous les pieces jointes en base
              $pjs = DB::table('pieces')->delete();
           }

            // Récupération de tous les utilisateurs étudiants
           $etudiants =DB::table('utilisateurs')->where('role_id', '=', Constantes::ETUDIANT)->get();

           // Pour tous les étudiants
           foreach ($etudiants as $key => $value) {
              
             // Récupération de la candidature de l'étudiant
             $candidature = DB::table('candidatures')->where('utilisateur_id', '=', $value->id);

              if($candidature->count()){
                 // Suppression de la candidature
                 $candidature->delete(); 
              }

              // Puis suppression de l'utilisateur
              $utilisateur = Utilisateur::find($value->id);
              $utilisateur->delete();
           }
         });
           return Redirect::route('configuration-get')->with('configuration-delete', 'Suppression des données terminée');
    }else{
      return Redirect::route('deleteDonnees')->with('delete-impossible', 'Mauvais mot de passe');
    }
  }

}
