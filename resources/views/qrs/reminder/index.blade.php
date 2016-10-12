@extends('layouts.default')

@section('title')
QR Reminder List ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">

	<div class="page-header"><h3><span class="glyphicon glyphicon-time"></span> QR Reminder List</h3></div>

	@include('layouts.paginator', ['result' => $result])

	<table class="table table-bordered table-striped table-hover sortable">
		<thead>
			<tr>
				<th width="105px">QR No.</th>
				<th width="90px">Date</th>
				<th>Customer Name</th>
				<th>Complaint</th>
				<th>Pending At</th>
				<th>PIC</th>
				<th colspan="2">Pending Days</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($result as $key)
				<tr>
					<td>{{ $key->refno }}</td>
					<td>{{ $key->GetComplaintDate() }}</td>
					<td>{{ $key->customer_name }}</td>
					<td>{{ $key->subject }}</td>
					<td>{!! $key->GetLink() !!}</td>
					<td>{{ $key->GetPIC() }}</td>
					<td>{{ $key->pending_day }}</td>
					@if ($key->isAdmin())
					<td><a href="{{ route('qrs.reminder.notify', $key->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-envelope"></span> Email</a></td>
					@endif
				</tr>
			@empty
				<td colspan="8">No results</td>
			@endforelse
		</tbody>
	</table>

	<script src="{{ asset('assets/js/bootstrap-sortable.js') }}"></script>

@endsection