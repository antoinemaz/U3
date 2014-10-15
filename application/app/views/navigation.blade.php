<div>
	<ul class="nav nav-tabs" role="tablist">
		<li class="{{Active::route(array('index'), 'active')}}"><a href="{{URL::route('index')}}">Accueil</a></li>

		@if(Auth::check())
			<li class="{{Active::route(array('deconnexion-get'), 'active')}}"><a href="{{URL::route('deconnexion-get')}}">Se déconnecter</a></li>
		@else
			<li class="{{Active::route(array('connexion-get'), 'active')}}"><a href="{{URL::route('connexion-get')}}">Se connecter</a></li>
			<li class="{{Active::route(array('creerCompte-get'), 'active')}}"><a href="{{URL::route('creerCompte-get')}}">Créer un compte</a></li>
		@endif
	</ul>
</div>