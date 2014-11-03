
<style>

.crumbs li a {  
    background-image: url('../style/images/bg-crumbs.png')!important;
}

</style>

<div id="breadcrumb" style="margin-top: 28px;">  
    <ul class="crumbs">  
        <li class="first"><a href="{{route('creationCandidature-get')}}" class="{{Active::route(array('creationCandidature-get'), 'currentEtape')}}" style="z-index:9;"><span></span>Informations</a></li>  
        <li><a href="{{route('diplome-get')}}" class="{{Active::route(array('diplome-get'), 'currentEtape')}}" style="z-index:8;">Diplomes</a></li>  
        <li><a href="{{route('stage-get')}}" class="{{Active::route(array('stage-get'), 'currentEtape')}}" style="z-index:7;">Stages</a></li>  
        <li><a href="{{route('piece-get')}}" class="{{Active::route(array('piece-get'), 'currentEtape')}}" style="z-index:6;">Pièces jointes</a></li>  
    	<li><a href="{{route('finalisation-get')}}" class="{{Active::route(array('finalisation-get'), 'currentEtape')}}" style="z-index:5;">Finalisation</a></li> 
    </ul>  
</div> 