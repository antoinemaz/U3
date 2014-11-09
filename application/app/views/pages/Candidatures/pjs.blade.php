<?php
  // Récupération de l'état de la candidature, si elle est envoyé, le formulaire ne sera plus éditable
  $readonly = false;
  if($etat == 2 or $etat == 3 ){
    $readonly = true;
  }
?>

<table class="table">
@foreach ($pjs as $pj)
	<tr>
		<td>{{ $pj->filename }}</td>
		<td><a class="file" href="../uploads/{{$pj->uid}}">Télécharger</a></td>

		@if($readonly == false)
			<td><a class="cn" id="{{$pj->id}}" class="file" href="">Supprimer</a></td>
		@endIf
	</tr>
@endforeach	
</table>

 <script>

	$('.cn').click(function (e) {

	    e.preventDefault();
	    var pic_id = $(this).attr('id');

	    $.get('/U3/candidature/upload/delete/'+pic_id, function(){
	    	$("#listPjs").load( {{ "'".URL::route('pjs')."'" }} );
	    	$("#charg").hide();
	    });
	});

 </script>