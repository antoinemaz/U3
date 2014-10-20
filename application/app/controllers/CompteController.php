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
				'email' => 'required|max:50|email|unique:candidatures',
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
			$username = Input::get('username');
			$password = Input::get('password');

			// code d'activation
			$code = str_random(60);

			// Enregistrement en base de données
			$create = Candidature::create(array(
				'email' => $email,
				'username' => $username,
				'password' => Hash::make($password),
				'code' => $code,
				'active' => 0));

			if($create){

				// Envoi du mail d'activation du compte
				Mail::send('emails.activerCompte', array('lien' => URL::route('activerCompte', $code), 'username' => $username), 
					function($message) use ($create){
					$message->to($create->email, $create->username)->subject('Ativation du compte');
				});

				// On redirige vers la page d'accueil
				return Redirect::route('index')
						->with('global', 'Compte créé');
			}
		}
	}

	// Page d'activation du compte
	public function getActivationCompte($code){

		// On récupère l'instance de l'utilisateur à partir du code d'acrivation
		$candidature = Candidature::where('code', '=', $code)->where('active','=', 0);

		if($candidature->count()){

			// Si on a une occurence en BDD, on récupère l'objet Utilisateur
			$candidature = $candidature->first();
		
			// active à 1 signifie activation du comppte. 
			// On set le code à vide car le compte est activé
			$candidature->active = 1;
			$candidature->code='';

			// MAJ des infos de l'utilisateur
			if($candidature->save()){

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

				$user = Candidature::find(Auth::user()->id);

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

				$candidature = Candidature::where('email', '=', Input::get('email'));

				if($candidature->count()){
					$candidature = $candidature->first();

					$code = str_random(60);
					$password = str_random(10);

					$candidature->code = $code;
					$candidature->password_tmp = Hash::make($password);

					if($candidature->save()){
						
					// Envoi du mail avec le nouveau mot de passe
					Mail::send('emails.passwordOublie', array('lien' => URL::route('reinitialisationPassword', $code), 
						'password' => $password), 
						function($message) use ($candidature){
						$message->to($candidature->email, $candidature->email)->subject('Réinitialisation du mode de passe');
						});
					
						return Redirect::route('index')
						->with('password_reinit', 'Un nouveau mot de passe a été envoyé par mail');
					}

				}
			}
		
			return Redirect::route('password-oublie-get')
			->with('erreur_passord_oublie', 'Impossible de satisfaire votre demande');
		}

		public function getReinitialisationPassword($code){
			
			$candidature = Candidature::where('code', '=', $code)
							->where('password_tmp', '!=', '');

			if($candidature->count()){

				$candidature = $candidature->first();
				$candidature->password = $candidature->password_tmp;
				$candidature->password_tmp = '';
				$candidature->code = '';

				if($candidature->save()){
					return Redirect::route('index')
							->with('validation_password_oublie', 'Votre mot de passe a bien été modifié');
				}

				return Redirect::route('index')
						->with('error_forget_password_init', 'Impossible de valider le changement de mot de passe');
			}

		}
}
