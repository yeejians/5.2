@extends('layouts.default')

@section('title')
Voter Setting :: Show ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-user"></span> Voter Details</h3></div>

	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Function Department:</th>
			<td>{{ $result->department }}</td>
		</tr>
		<tr>
			<th>Representative:</th>
			<td>{{ $result->user->display_name }}</td>
		</tr>
		<tr>
			<th>Site:</th>
			<td>{{ $result->site->name }}</td>
		</tr>
		@if ($result->backup->count() > 0)
		<tr>
			<th>Backup Person:</th>
			<td>
			@foreach ($result->backup as $backup)
				{{ $backup->user->display_name }}<br />
			@endforeach
			</td>
		</tr>
		@endif
		<tr>
			<th>Created at:</th>
			<td>{{ $result->created_at }}</td>
		</tr>
		<tr>
			<th>Updated at:</th>
			<td>{{ $result->updated_at }}</td>
		</tr>
		<tr>
			<th>Created by:</th>
			<td>{{ $result->creator() }}</td>
		</tr>
		<tr>
			<th>Updated by:</th>
			<td>{{ $result->updator() }}</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			@allow('tp.voter.create')
				<a href="{{ route('tp.voter.create') }}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span> Create</a>
			@endallow
			@allow('tp.voter.edit')
				<a href="{{ route('tp.voter.edit', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
			@endallow
			@allow('tp.voter.backup')
				<a href="{{ route('tp.voter.backup', $result->id) }}" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-user"></span> Backup Person</a>
			@endallow
			@if ($result->backup->count() == 0)
				@allow('tp.voter.delete')
					<a href="{{ route('tp.voter.delete', $result->id) }}" class="btn btn-danger btn-sm" onclick="return confirmAction('Are you sure?')"><span class="glyphicon glyphicon-remove"></span> Delete</a>
				@endallow
			@endif
				<a href="{{ route('tp.voter.index') }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</td>
		</tr>
	</table>

@endsection