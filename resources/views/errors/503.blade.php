<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>SYSTEM MAINTENANCE :: IOI Loders Croklaan Oils Sdn. Bhd.</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/error.css') }}" rel="stylesheet">

		<link rel="shortcut icon" href="{{ asset('assets/ico/favicon.png') }}">
	</head>

	<body>
        <div class="container">
            <div class="content">
                <div class="title">Be right back.</div>
				<div class="message">We're performing something COOL at the moment.</div>
				<div class="message">Please wait, we will be back shortly.</div>
				<div class="support">
					<p>Please contact <a href="mailto:{{ config('app.contact') }}">{{ config('app.contact') }}</a> if you need any immediate assistance.</p>
				</div>
            </div>
        </div>
    </body>
</html>
