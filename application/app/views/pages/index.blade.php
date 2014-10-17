@extends('template')

@section('content')

	@if(Session::has('compte-impossible-active'))
		<p>{{Session::get('compte-impossible-active')}}</p>
	@endif
	@if(Session::has('compte-active'))
		<p>{{Session::get('compte-active')}}</p>
	@endif	
	@if(Session::has('password_changed'))
		<p>{{Session::get('password_changed')}}</p>
	@endif	
	@if(Auth::check())
		<p>Salut {{Auth::user()->email}} </p>
	@else
		<p> Vous n'êtes pas connecté</p>
	@endif


		
	  {{ Form::open(array('files'=>true, 'id' => 'form')) }}
	  
	  {{ Form::label('file','File',array('id'=>'','class'=>'')) }}
	  {{ Form::file('file','',array('id'=>'file','class'=>'')) }}
	  <br/>
	  <!-- submit buttons -->
	  {{ Form::submit('Save',array('id'=>'addFile')) }}
	  
	  <!-- reset buttons -->
	  {{ Form::reset('Reset') }}
	  
	  {{ Form::close() }}

	  <div id="aaa">

	  </div>

	  <script>

	  	$(document).ready(function(){

	  		$("#aaa").load( {{ "'".URL::route('pjs')."'" }} );

	  		$('#form').on('submit',(function(e){

	  			e.preventDefault();

	  			var fichier = $("#file").prop('files');

		  		 $.ajax({
	            type: 'POST',
	            url: {{"'".URL::route('upload-post')."'"}},
	             data: new FormData( this ),
     			 processData: false,
      			 contentType: false,
	             success: function () {
	              
	              $("#aaa").load( {{ "'".URL::route('pjs')."'" }} );
	              $('#form').each(function(){
  					  this.reset();
					});
	            }

          });

	  		}));
	  	});

	  </script>

@stop