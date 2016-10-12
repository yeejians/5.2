@extends('layouts.default')

@section('title')
Report Setting ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">

	<div class="page-header"><h3><span class="glyphicon glyphicon-th-list"></span> Report Setting</h3></div>
	<p><a href="{{ route('sts.report.create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Create</a></p>

	<table class="table table-bordered table-striped table-hover sortable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Report Title</th>
				<th>Report URL</th>
				<th>File Name</th>
				<th>File Path</th>
				<th>Created</th>
				<th>Created By</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($result as $key)
				<tr>
					<td>{{ $key->id }}</td>
					<td>{{ $key->title }}</td>
					<td>{{ route($key->routename, $key->id) }}</td>
					<td>{{ $key->filename }}</td>
					<td>{{ $key->filepath }}</td>
					<td>{{ $key->created_at }}</td>
					<td>{{ $key->creator() }}</td>
					<td>
						<a href="{{ route('sts.report.show', $key->id) }}" class="btn btn-primary btn-xs">Details</a>
					</td>
				</tr>
			@empty
				<td colspan="8">No results</td>
			@endforelse
		</tbody>
	</table>

	<script src="{{ asset('assets/js/bootstrap-sortable.js') }}"></script>

@endsection