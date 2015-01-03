<?php

header('Content-type: text/plain; charset=utf-8');

class MailService {

	public function sendMailActivationCompte($user, $code){
		// Envoi du mail d'activation du compte
		Mail::send('emails.activerCompte', array('lien' => URL::route('activerCompte', $code)), 
			function($message) use ($user){
			$message->to($user->email, $user->username)->subject('Activation du compte');
		});
	}

	public function sendMailCompteGestionnaire($user, $libelleRole, $code, $password){
		// Envoi du mail au gestionnaire
		Mail::send('emails.activerCompteGestionnaire', 
			array('lien' => URL::route('activerCompte', $code), 'password' => $password, 'libelleRole' => $libelleRole), 
			function($message) use ($user, $libelleRole){
			$message->to($user->email, $user->username)->subject('Activation du compte '. $libelleRole);
		});
	}

	public function sendMailPasswordOublie($user, $code, $password){
		// Envoie du mail à l'utilisateur pour qu'il puisse se reconnecter grâce à un nouveau password
		Mail::send('emails.passwordOublie', array('lien' => URL::route('reinitialisationPassword', $code), 
		'password' => $password), 
		function($message) use ($user){
		$message->to($user->email, $user->email)->subject('Réinitialisation du mode de passe');
		});
	}

	public function sendMailCandidatureEnvoyee($gestionnaire, $candidature){
		// Envoie du mail à l'utilisateur pour qu'il puisse se reconnecter grâce à un nouveau password
		Mail::send('emails.candidatureEnvoyee', array('lien' => URL::route('detailCandidature-get', $candidature->id)),
		function($message) use ($gestionnaire){
		$message->to($gestionnaire->email, $gestionnaire->email)->subject('Nouvelle candidature');
		});
	}

	public function sendMailCandidatureValidee($mailUser, $candidature){
		// Envoie du mail à l'utilisateur pour qu'il puisse se reconnecter grâce à un nouveau password
		Mail::send('emails.candidatureValidee', array('nom' => $candidature->nom, 'prenom' => $candidature->prenom), 
		function($message) use ($mailUser){
		$message->to($mailUser, $mailUser)->subject('Candidature acceptée');
		});
	}

	public function sendMailCandidatureArevoir($mailUser, $candidature){
		// Envoie du mail à l'utilisateur pour qu'il puisse se reconnecter grâce à un nouveau password
		Mail::send('emails.candidatureArevoir', array('nom' => $candidature->nom, 'prenom' => $candidature->prenom,
		'lien' =>  URL::route('index')),
		function($message) use ($mailUser){
		$message->to($mailUser, $mailUser)->subject('Candidature à revoir');
		});
	}

	public function sendMailCandidatureRefusee($mailUser, $candidature){
		// Envoie du mail à l'utilisateur pour qu'il puisse se reconnecter grâce à un nouveau password
		Mail::send('emails.candidatureRefusee', array('nom' => $candidature->nom, 'prenom' => $candidature->prenom), 
		function($message) use ($mailUser){
		$message->to($mailUser, $mailUser)->subject('Refus de la candidature');
		});
	}
}
