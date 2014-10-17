<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>

	{{ HTML::style('style/css/bootstrap.css') }}
	{{ HTML::style('style/css/u3.css') }}
	{{ HTML::script('style/js/jquery-1.11.1.min.js') }}
	

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