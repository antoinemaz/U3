<table class="table">
@foreach ($pjs as $pj)
	<tr>
		<td>{{ $pj->filename }}</td>
		<td><a class="cn" id="{{$pj->id}}" class="file" href="">Supprimer</a></td>
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