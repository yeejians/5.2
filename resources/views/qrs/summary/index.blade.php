@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon-list-alt')
@section('header', 'Attachment Summary')

@section('details')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">

	@if ($result->attachment->count() > 0 || $result->oldattachment->count() > 0)
	<form method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<p>
		@if ($result->attachment->count() > 0)
			<a href="{{ route('qrs.summary.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		@endif
			<button type="submit" class="btn btn-danger btn-sm" style="display: none"><span class="glyphicon glyphicon-remove"></span> Delete</button>
		</p>

		<table class="table table-bordered table-striped table-hover sortable">
			<thead>
				<tr>
					<th>File Name</th>
					<th>Type</th>
					<th>Size</th>
					<th>Uploaded by</th>
					<th>Uploaded Date</th>
					<th>Section</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($result->attachment as $file)
				<tr>
					<td>
						<input type="checkbox" name="remove[]" class="remove" value="{{ $file->id }}">
						{!! $file->getlink()  !!}
					</td>
					<td>{{ $file->ext }}</td>
					<td>{{ $file->getsize() }}</td>
					<td>{{ $file->creator() }}</td>
					<td>{{ $file->created_at->format('d/m/Y h:i:s A') }}</td>
					<td>{{ $file->pivot->section }}</td>
				</tr>
				@endforeach
				@foreach ($result->oldattachment as $oldfile)
				<tr>
					<td>
						<input type="checkbox" name="removeold[]" class="remove" value="{{ $oldfile->id }}">
						{!! $oldfile->getlink()  !!}
					</td>
					<td>{{ $oldfile->ext }}</td>
					<td>{{ $oldfile->getsize() }}</td>
					<td>{{ $oldfile->old_uploador }}</td>
					<td>{{ $oldfile->created_at->format('d/m/Y h:i:s A') }}</td>
					<td>{{ $oldfile->section }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</form>
	@else
		<div class="alert alert-danger" role="alert" align="center">No Attachment</div>
	@endif

	<script src="{{ asset('assets/js/bootstrap-sortable.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.magnific.popup.min.js') }}"></script>
	<script>
		$(function(){
			$('.remove').on('change', function(){
				if ($('.remove:checked').length > 0){
					$('button[type="submit"]').show();
				}else{
					$('button[type="submit"]').hide();
				}
			});

			$('button[type="submit"]').on('click', function(){
				return confirmAction('Are you sure?');
			});

			Getlightbox();
		});
	</script>

@endsection