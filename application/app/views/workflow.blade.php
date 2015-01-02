
<style>

.crumbs li a {  
    background-image: url('../style/images/bg-crumbs.png')!important;
}

</style>

	@if($etat == Constantes::VALIDE)
		<div id="breadcrumb" style="display:none;">  
	@else
		<div id="breadcrumb" style="margin-top: 28px;">  
	@endIf

    <ul class="crumbs">  
        <li class="first"><a href="{{route('creationCandidature-get')}}" class="{{Active::route(array('creationCandidature-get'), 'currentEtape')}}" style="z-index:9;"><span></span>Informations</a></li>  
        <li><a href="{{route('diplome-get')}}" class="{{Active::route(array('diplome-get'), 'currentEtape')}}" style="z-index:8;">Diplomes</a></li>  
        <li><a href="{{route('stage-get')}}" class="{{Active::route(array('stage-get'), 'currentEtape')}}" style="z-index:7;">Stages</a></li>  
        <li><a href="{{route('piece-get')}}" class="{{Active::route(array('piece-get'), 'currentEtape')}}" style="z-index:6;">Pièces jointes</a></li>  
    	
    	@if($etat == Constantes::BROUILLON  or $etat == Constantes::AREVOIR)
    		<li><a href="{{route('finalisation-get')}}" class="{{Active::route(array('finalisation-get'), 'currentEtape')}}" style="z-index:5;">Finalisation</a></li> 
    	@else
    		<li><a href="#" class="linkDisabled" style="z-index:5;">Finalisation</a></li> 
    	@endIf
  
    </ul>  
</div> 

<div class="panelEtat">

	@if($etat == Constantes::BROUILLON)
		<div class="alert alert-info" role="alert">
			<strong>Votre candidature n'est pas encore soumise.</strong> <br/>Toutes vos modifications seront enregistrées en tant que brouillon.
		</div>
	@elseif($etat == Constantes::ENVOYE)
		<div class="alert alert-info" role="alert">
			<strong>Votre candidature a été envoyée.</strong> <br/>Elle est actuellement en cours d'examination
		</div>
		
	@elseif($etat == Constantes::VALIDE)
		<div class="alert alert-success" role="alert">
			<strong>Votre candidature a été validée</strong>
		</div>
	@elseif($etat == Constantes::AREVOIR)
		<div class="alert alert-warning" role="alert">
			Des ajustements doivent êtres effectuées sur votre candidature
		</div>

		<div class="panel panel-default commentaireGestionnaire">
 			 	<div class="panel-heading">
 			 		<span class="glyphicon glyphicon-info-sign"></span>
 			 		Commentaire du gestionnaire
 			 	</div>
 			 <div class="panel-body">{{$commentaire}}</div>
		</div>

	@else
		<div class="alert alert-danger" role="alert">
			<strong>Votre candidature a été refusée</strong>
		</div>
	@endIf
</div>