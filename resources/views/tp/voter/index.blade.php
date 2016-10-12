@extends('layouts.default')

@section('title')
Voter Setting ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">

	<div class="page-header"><h3><span class="glyphicon glyphicon-user"></span> Voter Setting</h3></div>
	@allow('tp.voter.create')
	<p><a href="{{ route('tp.voter.create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Create</a></p>
	@endallow

	<table class="table table-bordered table-striped table-hover sortable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Function Department</th>
				<th>Representative</th>
				<th>Backup</th>
				<th>Site</th>
				<th>Created</th>
				<th>Created By</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($result as $key)
				<tr>
					<td>{{ $key->id }}</td>
					<td>{{ $key->department }}</td>
					<td>{{ $key->user->display_name }}</td>
					<td>
						@if ($key->backup->count() > 0)
							@foreach ($key->backup as $backup)
							{{ $backup->user->display_name }}<br />
							@endforeach
						@endif
					</td>
					<td>{{ $key->site->shortname }}</td>
					<td>{{ $key->created_at }}</td>
					<td>{{ $key->creator() }}</td>
					<td>
						<a href="{{ route('tp.voter.show', $key->id) }}" class="btn btn-primary btn-xs">Details</a>
					</td>
				</tr>
			@empty
				<td colspan="8">No results</td>
			@endforelse
		</tbody>
	</table>

	<script src="{{ asset('assets/js/bootstrap-sortable.js') }}"></script>

@endsection