<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>

	{{ HTML::script('style/js/jquery-1.11.1.min.js') }}
	{{ HTML::script('style/js/bootstrap.js') }}

	{{ HTML::style('style/css/bootstrap.css') }}

	{{ HTML::style('style/datatable/media/css/jquery.dataTables.min.css') }}
	{{ HTML::script('style/datatable/media/js/jquery.dataTables.min.js') }}

	{{ HTML::style('style/datepicker/css/datepicker.css') }}
	{{ HTML::script('style/datepicker/js/bootstrap-datepicker.js') }}

	{{ HTML::script('style/js/pdfobject.js') }}
	
	{{ HTML::style('style/css/u3.css') }}

</head>
<body>

	<div id="main">

			<div id="header" class="container-fluid">
				{{ HTML::image('style/images/logo-evry.png', 'evry', array('class' => 'img-responsive img-header')) }}				
			</div>

			@include('navigation')
			@yield('content')
			<div class="bandeau">
				Université d'Evry-Val-d'Essonne Boulevard François Mitterrand 91025 Evry Cedex
			</div>
	</div>
</body>
</html>