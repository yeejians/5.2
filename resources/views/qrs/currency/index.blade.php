@extends('layouts.default')

@section('title')
Currency Setting ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">

	<div class="page-header"><h3><span class="glyphicon glyphicon-usd"></span> Currency List</h3></div>
	@allow('qrs.currency.create')
		<p><a href="{{ route('qrs.currency.create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Create</a></p>
	@endallow

	<table class="table table-bordered table-striped table-hover sortable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Currency Name</th>
				<th>Created</th>
				<th>Created By</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($result as $key)
				<tr>
					<td>{{ $key->id }}</td>
					<td>{{ $key->name }}</td>
					<td>{{ $key->created_at }}</td>
					<td>{{ $key->creator() }}</td>
					<td>
						<a href="{{ route('qrs.currency.show', $key->id) }}" class="btn btn-primary btn-xs">Details</a>
					</td>
				</tr>
			@empty
				<td colspan="7">No results</td>
			@endforelse
		</tbody>
	</table>

	<script src="{{ asset('assets/js/bootstrap-sortable.js') }}"></script>

@endsection