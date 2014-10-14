<?php

class CompteController extends BaseController {

	public function getCreateCompte()
	{
		return View::make('pages.compte.creation');
	}

	public function postCreateCompte()
	{
		$validator = Validator::make(Input::all(),
			array(
				'email' => 'required|max:50|email|unique:users',
				'username' => 'required|max:20|min:3|unique:users',
				'password' => 'required|min:6',
				'password_again' => 'required|same:password'));
	
		if($validator->fails()){
			return Redirect::route('creerCompte-get')
					->withErrors($validator)
					->withInput();
		}else{
			// Créer un compte
			$email = Input::get('email');
			$username = Input::get('username');
			$password = Input::get('password');

			// Activation code
			$code = str_random(60);

			$create = User::create(array(
				'email' => $email,
				'username' => $username,
				'password' => Hash::make($password),
				'code' => $code,
				'active' => 0));

			if($create){

				Mail::send('emails.activerCompte', array('lien' => URL::route('activerCompte', $code), 'username' => $username), 
					function($message) use ($create){
					$message->to($create->email, $create->username)->subject('Ativation du compte');
				});

				return Redirect::route('index')
						->with('global', 'Compte créé');
			}
		}
	}

	public function getActivationCompte($code){
		$user = User::where('code', '=', $code)->where('active','=', 0);

		if($user->count()){
			$user = $user->first();
		
			// Update active to user
			$user->active = 1;
			$user->code='';

			if($user->save()){
				return Redirect::route('index')->with('compte-active', 'Compte activé');
			}
		}
		return Redirect::route('index')->with('compte-impossible-active', 'Impossible d\'activer le compte');
	}
}
