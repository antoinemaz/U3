<div>
	<ul class="nav nav-tabs" role="tablist">
		<li class="{{Active::route(array('index'), 'active')}}"><a href="{{URL::route('index')}}">Accueil</a></li>

		@if(Auth::check())
			<li class="{{Active::route(array('deconnexion-get'), 'active')}}"><a href="{{URL::route('deconnexion-get')}}">Se déconnecter</a></li>
			<li class="{{Active::route(array('changerpassword-get'), 'active')}}"><a href="{{URL::route('changerpassword-get')}}">Changer mot de passe</a></li>
			
			@if(Auth::user()->role_id == 1)

					@if(Route::currentRouteName() == 'creationCandidature-get')
						<li class="active">
							<a href="{{URL::route('creationCandidature-get')}}">Créer une candidature</a>
						</li>
					@elseif(Route::currentRouteName() == 'diplome-get')
						<li class="active">
							<a href="{{URL::route('diplome-get')}}">Créer une candidature</a>
						</li>
					@elseif(Route::currentRouteName() == 'stage-get')
						<li class="active">
							<a href="{{URL::route('stage-get')}}">Créer une candidature</a>
						</li>
					@elseif(Route::currentRouteName() == 'piece-get')
						<li class="active">
							<a href="{{URL::route('piece-get')}}">Créer une candidature</a>
						</li>
					@elseif(Route::currentRouteName() == 'finalisation-get')
						<li class="active">
							<a href="{{URL::route('finalisation-get')}}">Créer une candidature</a>
						</li>
					@else
						<li>
							<a href="{{URL::route('creationCandidature-get')}}">Créer une candidature</a>
						</li>
					@endIf
				</li>
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