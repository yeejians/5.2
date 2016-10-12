@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-share-alt')
@section('header', 'Final Response')

@section('details')

	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">

	<p>
	@if ($result->IsInitiator() || $result->IsSalesCc())
		<a href="{{ route('qrs.response.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		<a href="{{ route('qrs.response.attachment', $result->id) }}" class="btn btn-success btn-sm" id="uploader"><span class="glyphicon glyphicon-file"></span> Add Attachment</a>
		@if ($result->GetRespondUser())
			<a href="{{ route('qrs.response.notify', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-envelope"></span> Send Notification</a>
		@endif
	@endif
	</p>

	@if ($result->finalresponse)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Final response to customer</legend>
				{!! $result->finalresponse !!}
			</fieldset>
		</div>
	</div>
	@else
		<div class="alert alert-danger" role="alert" align="center">No Final Response</div>
	@endif

	@if ($result->fileResponse->count() > 0)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Attachment</legend>
				@foreach ($result->fileResponse as $file)
					{!! $file->getblock()  !!}
				@endforeach
			</fieldset>
		</div>
	</div>
	@endif

	@if ($result->GetRespondUser())
	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="150px">Respond By:</th>
			<td>{{ $result->GetRespondUser() }}</td>
		</tr>
		<tr>
			<th>Respond Date:</th>
			<td>{{ $result->GetRespondDate() }}</td>
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