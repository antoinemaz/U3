<?php

class CompteController extends BaseController {

	// Vue de création d'un compte 
	public function getCreateCompte()
	{
		return View::make('pages.compte.creation');
	}

	public function postCreateCompte()
	{
		$validator = Validator::make(Input::all(),
			array(
				'email' => 'required|max:50|email|unique:utilisateurs',
				'password' => 'required|min:6',
				'password_again' => 'required|same:password'));
	
		// Si la validation échoue, on redirige vers la même page avec les erreurs
		if($validator->fails()){
			return Redirect::route('creerCompte-get')
					->withErrors($validator)
					->withInput();
		}else{
			// on set les valeurs des inputs dans des variables
			$email = Input::get('email');
			$password = Input::get('password');

			// code d'activation
			$code = str_random(60);

			// Enregistrement en base de données
			$create = Utilisateur::create(array(
				'email' => $email,
				'password' => Hash::make($password),
				'code' => $code,
				'active' => 0,
				'role_id' => Constantes::ETUDIANT));

			if($create){

				$candidature = Candidature::create(array(
					'utilisateur_id' => $create->id,
					'Pays' => 'France',
					'nationalite' => 'France',
					'sexe' => 'masculin',
					'save' => 0,
					'etat_id' => Constantes::BROUILLON));

				// Création de 6 lignes (pour formations et diplomes) : BAC, jusqu'à BAC+5
				for ($ligne = 1; $ligne <= 6; $ligne++){
  				  		Diplome::create(array(
  				  		'numero' => $ligne,
  				  		'candidature_id' => $candidature->id
  				  	));
				}

				// Création de 6 lignes (pour stages) : jusqu'à 5 expériences
				for ($ligne = 1; $ligne <= 5; $ligne++){
  				  		Stage::create(array(
  				  		'numero' => $ligne,
  				  		'candidature_id' => $candidature->id
  				  	));
				}

				// Envoi du mail d'activation du compte
				$mailService = new MailService();
				$mailService->sendMailActivationCompte($create, $code);

				// On redirige vers la page d'accueil
				return Redirect::route('index')
						->with('global', 'Compte créé');
			}
		}
	}

	// Page d'activation du compte
	public function getActivationCompte($code){

		// On récupère l'instance de l'utilisateur à partir du code d'acrivation
		$Utilisateur = Utilisateur::where('code', '=', $code)->where('active','=', 0);

		if($Utilisateur->count()){

			// Si on a une occurence en BDD, on récupère l'objet Utilisateur
			$Utilisateur = $Utilisateur->first();
		
			// active à 1 signifie activation du comppte. 
			// On set le code à vide car le compte est activé
			$Utilisateur->active = 1;
			$Utilisateur->code='';

			// MAJ des infos de l'utilisateur
			if($Utilisateur->save()){

				// Si ca c'est bien passé, redirection vers la page d'accueil
				return Redirect::route('index')->with('compte-active', 'Compte activé');
			}
		}
		return Redirect::route('index')->with('compte-impossible-active', 'Impossible d\'activer le compte');
	}

	// Page de connexion
	public function getConnexion(){
		return View::make('pages.compte.connexion');
	}

	public function postConnexion(){

		$validator = Validator::make(Input::all(), array(
			'email' => 'required|email',
			'password' => 'required'));

		if($validator->fails()){
			return Redirect::route('connexion-get')
			->withErrors($validator)
			->withInput();

			}else{

				// Récupération de la checkbox "Se souvenir de moi"
				// Si c'est à true, on cookie sera créé au sein du navigateur afin qu'il puisse 
				// se souvenir de l'utilisateur
				$remember = (Input::has('remember')) ? true : false;

				// On tente l'authentification avec les paramètres email, password, active
				$auth = Auth::attempt(array(
					'email' => Input::get('email'),
					'password' => Input::get('password'),
					'active' => 1),$remember);

				if($auth){
					// Utilisateur authentifié, on redirige vers la page demandée
					return Redirect::intended('/');
				}else{
					// Sinon, redirection vers la page de connexion
					return Redirect::route('connexion-get')->with('connexion-mauvais', 'Echec de connexion')->withInput();
				}
			}

			return Redirect::route('connexion-get')->with('connexion-probleme', 'Un problème a eu lieu lors de la connexion.
				Avez-vous activer votre compte ?')->withInput();
		}

		// Déconnexion de l'utilisateur
		public function getDeconnexion(){
			Auth::logout();
			return Redirect::route('index');
		}

		// Page de changement de mot de passe
		public function getChangerPassword(){
			return View::make('pages.compte.changerPassword');
		}

		public function postChangerPassword(){
			$validator = Validator::make(Input::all(),
			array(
				'oldpassword' => 'required',
				'password' => 'required|min:6',
				'password_again' => 'required|same:password'));

			if($validator->fails()){
				return Redirect::route('changerpassword-get')
				->withErrors($validator);
			}else{

				$user = Utilisateur::find(Auth::user()->id);

				$oldpassword = Input::get('oldpassword');
				$password = Input::get('password');

				if(Hash::check($oldpassword, $user->password)){
					$user->password = Hash::make($password);

					if($user->save()){
						return Redirect::route('index')
						->with('password_changed', 'Votre mot de passe a bien été changé');
					}
				}else{
					return Redirect::route('changerpassword-get')
					->with('ancien_passord_incorrect', 'Votre ancien mot de passe n\'est pas correct');
				}

			}

			return Redirect::route('changerpassword-get')
				->with('error_change_password', 'Impossible de changer votre mot de passe');
		}

		public function getPasswordOublie(){

			return View::make('pages.compte.passwordOublie');
		}

		public function postPasswordOublie(){

			$validator = Validator::make(Input::all(), array(
				'email' => 'required|email'
			));

			if($validator->fails()){
				return Redirect::route('password-oublie-get')
					->withErrors($validator)
					->withInput();
			}else{

				$Utilisateur = Utilisateur::where('email', '=', Input::get('email'));

				if($Utilisateur->count()){
					$Utilisateur = $Utilisateur->first();

					$code = str_random(60);
					$password = str_random(10);

					$Utilisateur->code = $code;
					$Utilisateur->password_tmp = Hash::make($password);

					if($Utilisateur->save()){
						
					// Envoi du mail avec le nouveau mot de passe
					$mailService = new MailService();
					$mailService->sendMailPasswordOublie($Utilisateur, $code, $password);
					
					return Redirect::route('index')
					->with('password_reinit', 'Un nouveau mot de passe vous a été envoyé par mail');
					}

				}
			}
		
			return Redirect::route('password-oublie-get')
			->with('erreur_passord_oublie', 'Impossible de satisfaire votre demande');
		}

		public function getReinitialisationPassword($code){
			
			$Utilisateur = Utilisateur::where('code', '=', $code)
							->where('password_tmp', '!=', '');

			if($Utilisateur->count()){

				$Utilisateur = $Utilisateur->first();
				$Utilisateur->password = $Utilisateur->password_tmp;
				$Utilisateur->password_tmp = '';
				$Utilisateur->code = '';

				if($Utilisateur->save()){
					return Redirect::route('index')
							->with('validation_password_oublie', 'Votre mot de passe a bien été modifié');
				}

				return Redirect::route('index')
						->with('error_forget_password_init', 'Impossible de valider le changement de mot de passe');
			}

		}
}
