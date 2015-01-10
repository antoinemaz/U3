<?php 

class ConfigurationController extends BaseController {


    public function getConfiguration(){

      // Récupération des gestionnaires et des admins
      $gestionnairesAndAdmins = DB::table('utilisateurs')
      ->where('role_id', Constantes::GESTIONNAIRE)->orWhere('role_id', Constantes::ADMINISTRATEUR)->get();

      // Récupération des roles (sauf étudiants)
      $tabRoles = DB::table('roles')->whereNotIn('id', array(Constantes::ETUDIANT))->get();

      // Récupération de la valeur de la config sendMailsToGestionnaires
      $active = $this->getValueOfConfiguration()->active;

      //Tableau temporaire à remplacer par ce que l'on réupère dans redmine
      $tabFilliere = ["MIAGE","MIAGE App","ASR","Info","FC"];

      $annee_convoitee[2] = ('Année L2');
      $annee_convoitee[3] = 'Année L3';
      $annee_convoitee[4] = 'Année M1';
      $annee_convoitee[5] = 'Année M2';
      $annee_convoitee[6] = 'Information sur le site';

      //Récupération dans la table associative des couples Année/Fillière du user courant
       $coupleAnneeFilliere= DB::table('correspondances')
      ->where('iduser', Auth::user()->id)->get();

      return View::make('pages.gestion.configuration')
      ->with(array('sendMailsGestionnaires' => $active, 'gestionnairesAndAdmins' => $gestionnairesAndAdmins, 
        'tabRoles' => $tabRoles, 'tabFiliere' => $tabFilliere, 'coupleAnneeFilliere' => $coupleAnneeFilliere, 'annee_convoitee' => $annee_convoitee));
    }


    public function postConfiguration(){

      $value = $this->getValueOfConfiguration();
      $value->active = Input::get('sendMailsGestionnaires');

      if($value->save()){
        return Redirect::route('configuration-get')->with('configuration-enregistre', 'Configuration enregistrée');
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
        'iduser' => $idUser,
        'filieres_resp' =>  $filliere,
        'annees_resp' => $annee,
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



}
