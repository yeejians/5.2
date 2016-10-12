@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-envelope')
@section('header', 'Notification')

@section('details')

	<div class="jumbotron" align="center">
		<p id="message">Sending notification email to users, please wait...</p>
		<img src="{{ asset('assets/img/preloader.gif') }}"/>
	</div>

	<script>
		$(function(){
			var
				$message	= $('#message'),
				$img		= $('img'),
				$jumbotron	= $('.jumbotron');

			setTimeout(function(){
				var Response = $.ajax({
					url: '{{ $data['url'] }}',
					type: 'get',
					async: false
				}).responseText;

				if(Response == 'SUCCESS'){
					$message.text('Notification email sent succesfully, redirecting...');
					setTimeout(function(){window.location = ('{{ $data['previous'] }}');}, 5000);
				}else{
					$message.remove(); 
					$img.remove(); 
					$jumbotron.append('<div class="alert alert-danger"><strong>Whoops! Something\'s went wrong,<br /> Please contact {{ config('app.contact') }}<br /><br />Error Response: </strong>'+Response+'</div>');
					$jumbotron.append('<a href="javascript:history.back();" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>');
				}
			}, 3000);
		});
	</script>

@endsection