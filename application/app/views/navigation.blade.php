<div>
	<ul class="nav nav-tabs" role="tablist">
		<li class="{{Active::route(array('index'), 'active')}}"><a href="{{URL::route('index')}}">Accueil</a></li>

		@if(Auth::check())
			<li class="{{Active::route(array('deconnexion-get'), 'active')}}"><a href="{{URL::route('deconnexion-get')}}">Se déconnecter</a></li>
			<li class="{{Active::route(array('changerpassword-get'), 'active')}}"><a href="{{URL::route('changerpassword-get')}}">Changer mot de passe</a></li>
			
			@if(Auth::user()->role_id == 1)
				<li class="{{Active::route(array('creationCandidature-get'), 'active')}}"><a href="{{URL::route('creationCandidature-get')}}">Créer une candidature</a></li>
			@else
				<li class="{{Active::route(array('gestionnaires-get'), 'active')}}"><a href="{{URL::route('gestionnaires-get')}}">Gérer les gestionnaires</a></li>
				<li class="{{Active::route(array('listeCandidatures-get'), 'active')}}"><a href="{{URL::route('listeCandidatures-get')}}">Gérer les candidatures</a></li>
			@endif

		@else
			<li class="{{Active::route(array('connexion-get'), 'active')}}"><a href="{{URL::route('connexion-get')}}">Se connecter</a></li>
			<li class="{{Active::route(array('creerCompte-get'), 'active')}}"><a href="{{URL::route('creerCompte-get')}}">Créer un compte</a></li>
			<li class="{{Active::route(array('password-oublie-get'), 'active')}}"><a href="{{URL::route('password-oublie-get')}}">Mot de passe oublié</a></li>				
		@endif
	</ul>
</div>