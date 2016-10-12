@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-ok-circle')
@section('header', 'QA Verification')

@section('details')

	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">

	<p>
	@if ($result->IsAdmin())
		<a href="{{ route('qrs.verification.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		@if ($result->IsNotLock())
			<a href="{{ route('qrs.verification.attachment', $result->id) }}" class="btn btn-success btn-sm" id="uploader"><span class="glyphicon glyphicon-file"></span> Add Attachment</a>
			@if ($result->GetVerifiedUser())
				<a href="{{ route('qrs.verification.notify', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-envelope"></span> Send Notification</a>
			@endif
			<a href="{{ route('qrs.verification.lock', $result->id) }}" class="btn btn-default btn-sm" onclick="return confirmAction('Are you sure?');"><span class="glyphicon glyphicon-lock"></span> Lock Case</a>
		@endif
		@if ($result->locked)
			<a href="{{ route('qrs.verification.unlock', $result->id) }}" class="btn btn-default btn-sm" onclick="return confirmAction('Are you sure?');"><span class="glyphicon glyphicon-briefcase"></span> Unlock</a>
		@endif
	@endif
	</p>

	@if ($result->verification)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Remarks of implementation and effectiveness</legend>
				{!! $result->verification !!}
			</fieldset>
		</div>
	</div>
	@else
		<div class="alert alert-danger" role="alert" align="center">No Verification</div>
	@endif

	@if ($result->fileVerification->count() > 0)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Attachment</legend>
				@foreach ($result->fileVerification as $file)
					{!! $file->getblock()  !!}
				@endforeach
			</fieldset>
		</div>
	</div>
	@endif

	@if ($result->GetVerifiedUser())
	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Case Status:</th>
			<td>{{ $result->GetCaseStatus() }}</td>
		</tr>
		<tr>
			<th>Lock Status:</th>
			<td>{{ $result->GetLockStatus() }}</td>
		</tr>
		<tr>
			<th>Verified / Locked By:</th>
			<td>{{ $result->GetVerifiedUser() }}</td>
		</tr>
		<tr>
			<th>Verified / Locked Date:</th>
			<td>{{ $result->GetVerifiedDate() }}</td>
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