@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-duplicate')
@section('header', 'External Info')

@section('details')

	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">

	<p>
	@if ($result->IsAdmin() && $result->IsNotLock())
		<a href="{{ route('qrs.external.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		<a href="{{ route('qrs.external.attachment', $result->id) }}" class="btn btn-success btn-sm" id="uploader"><span class="glyphicon glyphicon-file"></span> Add Attachment</a>
	@endif
	</p>

	@if ($result->external_info)
	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="150px">External Info:</th>
			<td>{{ $result->GetExternalInfo() }}</td>
		</tr>
		<tr>
			<th>Submit Date:</th>
			<td>{{ $result->GetExternalInfoSubmitDate() }}</td>
		</tr>
		<tr>
			<th>Remarks:</th>
			<td>{!! $result->external_remark !!}</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<th>Modified By:</th>
			<td>{{ $result->GetExternalModifiedUser() }}</td>
		</tr>
		<tr>
			<th>Modified Date:</th>
			<td>{{ $result->GetExternalModifiedDate() }}</td>
		</tr>
	</table>
	@else
		<div class="alert alert-danger" role="alert" align="center">No External Info</div>
	@endif

	@if ($result->fileExternal->count() > 0)
		<div class="row">
			<div class="col-md-12">
				<fieldset class="border">
					<legend class="border">Attachment</legend>
					@foreach ($result->fileExternal as $file)
						{!! $file->getblock()  !!}
					@endforeach
				</fieldset>
			</div>
		</div>
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