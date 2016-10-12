@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-bullhorn')
@section('header', 'My Feedback')

@section('details')

	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bubbles.css') }}" rel="stylesheet">

	<p>
	@if ($result->IsNotLock())
		<a href="{{ route('qrs.feedback.create', $result->id) }}" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-pencil"></span> Add My Feedback</a>
		<a href="{{ route('qrs.feedback.attachment', $result->id) }}" class="btn btn-success btn-sm" id="uploader"><span class="glyphicon glyphicon-file"></span> Add Attachment</a>
		@if ($result->GetLastFeedbackUser())
			<a href="{{ route('qrs.feedback.notify', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-envelope"></span> Send Notification</a>
		@endif
	@endif
	</p>

	@if ($result->feedbacks->count() > 0)
	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<td>
				@foreach ($result->feedbacks as $key)
					<div class="chat{{ $key->GetPosition() }}">
						<div class="bubble"{!! $key->GetBGColor() !!}>
							<p class="text-success{{ $key->GetPosition() }}" title="{{ $key->GetTimeFull() }}">{{ $key->creator() }} <small class="text-muted">at {{ $key->GetTime() }}</small></p>
							{!! $key->GetContent() !!}
						</div>
					</div>
				@endforeach
			</td>
		</tr>
	</table>
	@else
		<div class="alert alert-danger" role="alert" align="center">No Feedback</div>
	@endif

	<script src="{{ asset('assets/js/jquery.magnific.popup.min.js') }}"></script>
	<script>
		$(function(){
			$('#uploader').on('click', function(){
				Uploader($(this).attr('href'));
				return false;
			});

			Getlightbox();
		});
	</script>

@endsection