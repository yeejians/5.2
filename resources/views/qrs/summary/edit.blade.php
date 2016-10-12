@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon-list-alt')
@section('header', 'Edit - Attachment Summary')

@section('details')

	<form method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<table class="table table-condensed table-striped table-hover">
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
						<div class="row">
							<div class="col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><input type="checkbox" name="edit[]" id="edit{{ $file->id }}" value="{{ $file->id }}" /></span>
									<input type="text" class="form-control" name="name[{{ $file->id }}]" value="{{ $file->name }}" data-id="{{ $file->id }}" />
								</div>
							</div>
						</div>
					</td>
					<td>{{ $file->ext }}</td>
					<td>{{ $file->getsize() }}</td>
					<td>{{ $file->creator() }}</td>
					<td>{{ $file->created_at->format('d/m/Y h:i:s A') }}</td>
					<td>{{ $file->pivot->section }}</td>
				</tr>
				@endforeach
			</tbody>
		</table><br />
		<center>
			<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
			<a href="{{ route('qrs.summary.index', $result->id) }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
		</center>
	</form>

	<script>
		$(function(){
			$('.form-control').on('focus', function(){
				var text		= $(this).val();
				var $checkbox	= $('#edit'+$(this).data('id'));

				$checkbox.prop('checked', true);
				$(this).select();

				$(this).on('blur', function(){
					if ($(this).val() == ''){
						$checkbox.prop('checked', false);
						$(this).val(text);
					}
				});
			});
		});
	</script>

@endsection