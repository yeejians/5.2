@extends('layouts.default')

@section('title')
Site Setting ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">

	<div class="page-header"><h3><span class="glyphicon glyphicon-flag"></span> Site Setting</h3></div>
	<p><a href="{{ route('cp.site.create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Create</a></p>

	<table class="table table-bordered table-striped table-hover sortable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Site Name</th>
				<th>Short Name</th>
				<th>SAP Code</th>
				<th>Created</th>
				<th width="60px">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($result as $key)
				<tr>
					<td>{{ $key->id }}</td>
					<td>{{ $key->name }}</td>
					<td>{{ $key->shortname }}</td>
					<td>{{ $key->sapcode }}</td>
					<td>{{ $key->created_at }}</td>
					<td>
						<a href="{{ route('cp.site.show', $key->id) }}" class="btn btn-primary btn-xs">Details</a>
					</td>
				</tr>
			@empty
				<td colspan="7">No results</td>
			@endforelse
		</tbody>
	</table>

	<script src="{{ asset('assets/js/bootstrap-sortable.js') }}"></script>

@endsection