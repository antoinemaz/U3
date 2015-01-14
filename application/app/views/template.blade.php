<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>

	{{ HTML::script('js-css-img/js/jquery-1.11.1.min.js') }}
	{{ HTML::script('js-css-img/js/bootstrap.js') }}

	{{ HTML::style('js-css-img/css/bootstrap.css') }}

	{{ HTML::style('js-css-img/datatable/media/css/jquery.dataTables.min.css') }}
	{{ HTML::script('js-css-img/datatable/media/js/jquery.dataTables.min.js') }}

	{{ HTML::style('js-css-img/datepicker/css/datepicker.css') }}
	{{ HTML::script('js-css-img/datepicker/js/bootstrap-datepicker.js') }}

	{{ HTML::script('js-css-img/js/pdfobject.js') }}
	
	{{ HTML::style('js-css-img/css/u3.css') }}

</head>
<body>

	<div id="main">

			<div id="header" class="container-fluid">
				{{ HTML::image('js-css-img/images/logo_univ.png', 'evry', array('class' => 'img-responsive img-header-responsive')) }}	
				<div class="titre-responsive">
				Portail de dépot de candidature</div>
				{{ HTML::image('js-css-img/images/logo-evry.png', 'evry', array('class' => 'img-responsive img-header')) }}				
			</div>

			@include('navigation')
			@yield('content')
			<div class="bandeau">
				Université d'Evry-Val-d'Essonne Boulevard François Mitterrand 91025 Evry Cedex
			</div>
	</div>
</body>
</html>