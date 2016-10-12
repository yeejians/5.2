@extends('layouts.default')

@section('title')
Notification Setting ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">
	<div class="page-header"><h3><span class="glyphicon glyphicon-th-list"></span> Notification Mail Content</h3></div>

	@allow('qrs.notification.create')
		<p><a href="{{ route('qrs.notification.create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Create</a></p>
	@endallow

	<table class="table table-bordered table-striped table-hover sortable">
		<thead>
			<tr>
				<th>#ID</th>
				<th>Prefix Key</th>
				<th>Name title</th>
				<th>Subject</th>
				<th>Content</th>
				<th>Modified</th>
				<th>Modified By</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($result as $key)
				<tr>
					<td>{{ $key->id }}</td>
					<td>{{ $key->prefixkey }}</td>
					<td>{{ $key->name }}</td>
					<td>{{ $key->subject }}</td>
					<td>{{ str_limit($key->message, 80) }}</td>
					<td>{{ $key->updated_at }}</td>
					<td>{{ $key->updator() }}</td>
					<td>
						<a href="{{ route('qrs.notification.show', $key->id) }}" class="btn btn-primary btn-xs">Details</a>
					</td>
				</tr>
			@empty
				<td colspan="7">No results</td>
			@endforelse
		</tbody>
	</table>

@endsection