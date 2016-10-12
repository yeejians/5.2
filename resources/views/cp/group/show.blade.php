@extends('layouts.default')

@section('title')
Group Setting :: Show ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-bullhorn"></span> Group Details</h3></div>

	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Group ID:</th>
			<td>{{ $result->id }}</td>
		</tr>
		<tr>
			<th>Group Name:</th>
			<td>{{ $result->name }}</td>
		</tr>
		<tr>
			<th>Created at:</th>
			<td>{{ $result->created_at }}</td>
		</tr>
		<tr>
			<th>Updated at:</th>
			<td>{{ $result->updated_at }}</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<a href="{{ route('cp.group.create') }}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span> Create</a>
				<a href="{{ route('cp.group.edit', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
				<a href="{{ route('cp.group.assign', $result->id) }}" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-user"></span> Assign</a>
			@if ($result->users->count() == 0)
				<a href="{{ route('cp.group.delete', $result->id) }}" class="btn btn-danger btn-sm" onclick="return confirmAction('Are you sure?')"><span class="glyphicon glyphicon-remove"></span> Delete</a>
			@endif
				<a href="{{ route('cp.group.index') }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</td>
		</tr>
		@if ($result->users->count() > 0)
		<tr>
			<th>Current Users:</th>
			<td>
			@foreach ($result->users as $user)
				{{ $user->display_name }}<br />
			@endforeach
			</td>
		</tr>
		@endif
	</table>

@endsection