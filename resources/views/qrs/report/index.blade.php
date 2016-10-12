@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-file')
@section('header', 'Case Leader Report')

@section('details')

	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">

	<p>
	@if ($result->IsNotLock())
		@if ($result->IsCaseLeader() && $result->IsReportNotLock())
			<a href="{{ route('qrs.report.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		@endif
		@if ($result->IsAssistant() || $result->IsCaseLeader())
			<a href="{{ route('qrs.report.attachment', $result->id) }}" class="btn btn-success btn-sm" id="uploader"><span class="glyphicon glyphicon-file"></span> Add Attachment</a>
		@endif
		@if ($result->IsCaseLeader() && $result->GetReportedUser())
			<a href="{{ route('qrs.report.notify', ['report', $result->id]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-envelope"></span> Send Notification</a>
		@endif
		@if ($result->IsAssistant() && $result->GetLastAssistantUpload())
			<a href="{{ route('qrs.report.notify', ['attachment', $result->id]) }}" class="btn btn-assign btn-sm"><span class="glyphicon glyphicon-envelope"></span> Notify Case Leader</a>
		@endif
	@endif
	</p>

	@if ($result->caseleader_finding || $result->caseleader_rootcause || $result->caseleader_corrective || $result->GetExpectedCompleteDate())
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Investigation & Finding</legend>
				{!! $result->caseleader_finding !!}
			</fieldset>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Root Cause</legend>
				{!! $result->caseleader_rootcause !!}
			</fieldset>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Corrective / Prevention Action</legend>
				{!! $result->caseleader_corrective !!}
			</fieldset>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Expected Completion Date</legend>
				{{ $result->GetExpectedCompleteDate() }}
			</fieldset>
		</div>
	</div>
	@else
		<div class="alert alert-danger" role="alert" align="center">No Case Leader Report</div>
	@endif

	@if ($result->fileReport->count() > 0)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Attachment</legend>
				@foreach ($result->fileReport as $file)
					{!! $file->getblock()  !!}
				@endforeach
			</fieldset>
		</div>
	</div>
	@endif

	@if ($result->GetReportedUser())
	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="150px">Reported By:</th>
			<td>{{ $result->GetReportedUser() }}</td>
		</tr>
		<tr>
			<th>Reported Date:</th>
			<td>{{ $result->GetReportedDate() }}</td>
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