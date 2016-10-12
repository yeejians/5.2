@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-eye-open')
@section('header', 'QA Review')

@section('details')

	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">

	<p>
	@if ($result->IsAdmin() && $result->IsNotLock())
		<a href="{{ route('qrs.review.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		<a href="{{ route('qrs.review.attachment', $result->id) }}" class="btn btn-success btn-sm" id="uploader"><span class="glyphicon glyphicon-file"></span> Add Attachment</a>
		@if ($result->GetReviewedUser())
			<a href="{{ route('qrs.review.notify', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-envelope"></span> Send Notification</a>
		@endif
	@endif
	</p>

	@if ($result->qa_comment)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Review Report</legend>
				{!! $result->qa_comment !!}
			</fieldset>
		</div>
	</div>
	@else
		<div class="alert alert-danger" role="alert" align="center">No Review Report</div>
	@endif

	@if ($result->fileReview->count() > 0)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Attachment</legend>
				@foreach ($result->fileReview as $file)
					{!! $file->getblock()  !!}
				@endforeach
			</fieldset>
		</div>
	</div>
	@endif

	@if ($result->GetReviewedUser())
	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="150px">Reviewed By:</th>
			<td>{{ $result->GetReviewedUser() }}</td>
		</tr>
		<tr>
			<th>Reviewed Date:</th>
			<td>{{ $result->GetReviewedDate() }}</td>
		</tr>
	</table>
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