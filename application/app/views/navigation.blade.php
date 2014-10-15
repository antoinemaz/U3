<div>
	<ul class="nav nav-tabs" role="tablist">
		<li><a href="{{URL::route('index')}}">Accueil</a></li>

		@if(Auth::check())
			<li><a href="{{URL::route('deconnexion-get')}}">Se déconnecter</a></li>
		@else
			<li><a href="{{URL::route('connexion-get')}}">Se connecter</a></li>
			<li class="active"><a href="{{URL::route('creerCompte-get')}}">Créer un compte</a></li>
		@endif
	</ul>
</div>