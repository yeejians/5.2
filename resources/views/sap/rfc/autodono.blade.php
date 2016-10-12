@extends('layouts.default')

@section('title')
SAP RFC Service Gateway ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-list-alt"></span> Outbound Number Update Service</h3></div>
	<label class="checkbox"><input type="checkbox" id="autorefresh" checked="checked" /> Service refresh in next <span id="timer">60</span> seconds</label>
	<div class="jumbotron" align="center"><p id="message">{{ $message }}</p></div>
	<script>
		$(function(){
			var timer = $('#timer').text();
			setInterval(function(){
				if($('#autorefresh').is(':checked')){
					$('#timer').text(--timer);
					if (timer == 0) {
						location.reload(true);
					}
				}
			}, 1000);
		});
	</script>
	
@endsection