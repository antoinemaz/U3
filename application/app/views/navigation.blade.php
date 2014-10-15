<div>
	<ul class="nav nav-tabs" role="tablist">
		<li class="{{Active::route(array('index'), 'active')}}"><a href="{{URL::route('index')}}">Accueil</a></li>

		@if(Auth::check())
			<li class="{{Active::route(array('deconnexion-get'), 'active')}}"><a href="{{URL::route('deconnexion-get')}}">Se déconnecter</a></li>
<<<<<<< HEAD
			<li class="{{Active::route(array('changerpassword-get'), 'active')}}"><a href="{{URL::route('changerpassword-get')}}">Changer mot de passe</a></li>
=======
			<li class="{{Active::route(array('creationCandidature-get'), 'active')}}"><a href="{{URL::route('creationCandidature-get')}}">Créer une candidature</a></li>
>>>>>>> origin/master
		@else
			<li class="{{Active::route(array('connexion-get'), 'active')}}"><a href="{{URL::route('connexion-get')}}">Se connecter</a></li>
			<li class="{{Active::route(array('creerCompte-get'), 'active')}}"><a href="{{URL::route('creerCompte-get')}}">Créer un compte</a></li>		
			<li class="{{Active::route(array('creationCandidature-get'), 'active')}}"><a href="{{URL::route('creationCandidature-get')}}">Créer une candidature</a></li>	
		@endif
	</ul>
</div>