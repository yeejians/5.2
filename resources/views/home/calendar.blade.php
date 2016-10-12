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
		<link href="{{ asset('assets/css/zabuto_calendar.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

		<link rel="shortcut icon" href="{{ asset('assets/ico/favicon.png') }}">

		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.placeholder.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/main.js') }}"></script>
		<style>
			body {
				padding: 0;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div id="calendar"></div>
				</div>
			</div>
		</div>
		<script src="{{ asset('assets/js/zabuto_calendar.min.js') }}"></script>
		<script>
			$(function(){
				$('#calendar').zabuto_calendar({
					today: true,
					ajax: {
						url: '{{ route('calendar') }}',
						modal: true
					}
				});
			});
		</script>
	</body>
</html>