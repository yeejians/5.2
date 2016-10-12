<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>
			@section('title')
			IOI Loders Croklaan Oils Sdn. Bhd.
			@show
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/button.css') }}" rel="stylesheet">

		<link rel="shortcut icon" href="{{ asset('assets/ico/favicon.png') }}">

		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.placeholder.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/main.js') }}"></script>
	</head>
	<body>
		<div class="container-fluid">
			@include('layouts.nav')
			@include('layouts.alert')
			@yield('content')
		</div>
		@if ($_SERVER['LOGON_USER'] == 'LC-DOMAIN\ylam01')
			<div align="center"><small><span class="label label-default">page load time {{ bcadd((microtime(true) - LARAVEL_START), 0, 2) }} sec</span></small></div>
		@endif
	</body>
</html>