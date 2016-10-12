@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-comment')
@section('header', 'QA Information')

@section('details')

	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">

	<p>
	@if ($result->IsAdmin())
		<a href="{{ route('qrs.information.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		<a href="{{ route('qrs.information.attachment', $result->id) }}" class="btn btn-success btn-sm" id="uploader"><span class="glyphicon glyphicon-file"></span> Add Attachment</a>
	@endif
	</p>

	@if ($result->information)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Information Collection</legend>
				{!! $result->information !!}
			</fieldset>
		</div>
	</div>
	@else
		<div class="alert alert-danger" role="alert" align="center">No Information</div>
	@endif

	@if ($result->fileInformation->count() > 0)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Attachment</legend>
				@foreach ($result->fileInformation as $file)
					{!! $file->getblock()  !!}
				@endforeach
			</fieldset>
		</div>
	</div>
	@endif

	@if ($result->GetInformationModifiedUser())
	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="150px">Modified By:</th>
			<td>{{ $result->GetInformationModifiedUser() }}</td>
		</tr>
		<tr>
			<th>Modified Date:</th>
			<td>{{ $result->GetInformationModifiedDate() }}</td>
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