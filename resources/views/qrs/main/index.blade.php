@extends('layouts.default')

@section('title')
QR List ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">

	<div class="page-header"><h3><span class="glyphicon glyphicon-list-alt"></span> QR List</h3></div>

	<div class="row">
		<div class="col-md-8">
		<a href="#" id="create" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Create</a>
		@if ($record)
			<a href="{{ route('qrs.index') }}" class="btn btn-info"><span class="glyphicon glyphicon-remove"></span> Clear Result</a>
			<strong>{{ (request()->input('search') ? 'Search' : 'Filter') }} by </strong>{!! $record !!}
		@endif
		</div>
		<div class="col-md-4">
			<div class="pull-right right-space" style="width: 300px;">
				<select class="form-control populate placeholder" name="filter" id="filter">
					<option></option>
					<optgroup label="Filter Company">
						@foreach ($sites as $company)
							<option value="QR{{ $company->shortname }}"{!! (request()->input('filter') == 'QR'.$company->shortname ? ' selected="selected"' : '') !!}>{{ $company->name }}</option>
						@endforeach
					</optgroup>
					<optgroup label="Filter Status">
						@foreach ($status as $notification)
							<option value="{{ $notification->status }}"{!! (request()->input('filter') == $notification->status ? ' selected="selected"' : '') !!}>{{ $notification->status }}</option>
						@endforeach
					</optgroup>
				</select>
			</div>
		</div>
	</div>

	@include('layouts.paginator', ['result' => $result])

	<table class="table table-bordered table-striped table-hover sortable">
		<thead>
			<tr>
				<th width="105px">QR No.</th>
				<th width="90px">Date</th>
				<th>Customer Name</th>
				<th>Complaint</th>
				<th>Case Leader</th>
				<th width="200px">Status</th>
				<th width="45px">Rev</th>
				<th width="45px">FR</th>
				<th width="45px">CoC</th>
				<th width="45px">Days</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($result as $key)
				<tr>
					<td><a href="{{ route('qrs.show', $key->id) }}">{{ $key->refno }}</a></td>
					<td>{{ $key->GetComplaintDate() }}</td>
					<td>{{ $key->customer_name }}</td>
					<td>{{ $key->subject }}</td>
					<td>{{ $key->GetCaseleader() }}</td>
					<td>{!! $key->GetStatus() !!}</td>
					<td>{!! $key->GetRev() !!}</td>
					<td>{!! $key->GetFR() !!}</td>
					<td>{!! $key->GetCoC() !!}</td>
					<td><a href="{{ route('qrs.timeline.index', $key->id) }}">{!! $key->GetTotalTimeline() !!}</a></td>
				</tr>
			@empty
				<td colspan="10">No results</td>
			@endforelse
		</tbody>
	</table>

	<div class="modal fade" id="select" tabindex="-1" role="dialog" aria-labelledby="selectLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="selectLabel">Please select company</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<select class="form-control" name="site_id" id="site_id">
								@foreach ($sites as $site)
									<option value="{{ $site->id }}">{{ $site->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Back</button>
					<button type="button" class="btn btn-primary" id="next">Next</button>
				</div>
			</div>
		</div>
	</div>

	@include('layouts.paginator', ['result' => $result])

	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap-sortable.js') }}"></script>
	<script>
		$(function(){
			$('#site_id').select2();

			$('#filter').select2({
				placeholder: "---------- Filter Company / Status ----------",
				allowClear: true
			});

			$('#filter').on('change', function(){
				window.location = '{{ route('qrs.index') }}?filter=' + $(this).val();
			});


			$('#create').on('click', function(){
				$('#select').modal('show');

				return false;
			});

			$('#next').on('click', function(){
				if ($('#site_id').val() > 0){
					window.location = '{{ config('app.url') }}/qrs/create/' + $('#site_id').val();
				}else{
					alert('Please select company');
				}

				return false;
			});
		});
	</script>

@endsection