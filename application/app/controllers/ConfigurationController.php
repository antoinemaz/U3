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

      return View::make('pages.gestion.configuration')
      ->with(array('sendMailsGestionnaires' => $active, 'gestionnairesAndAdmins' => $gestionnairesAndAdmins, 
        'tabRoles' => $tabRoles));
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

}
