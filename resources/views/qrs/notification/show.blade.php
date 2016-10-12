@extends('layouts.default')

@section('title')
Notification Setting :: Details ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-list-alt"></span> {{ $result->prefixkey }}</h3></div>

	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">#ID:</th>
			<td>{{ $result->id }}</td>
		</tr>
		<tr>
			<th>Prefix key:</th>
			<td>{{ $result->prefixkey }}</td>
		</tr>
		<tr>
			<th>Name title:</th>
			<td>{{ $result->name }}</td>
		</tr>
		<tr>
			<th>Subject:</th>
			<td>{{ $result->subject }}</td>
		</tr>
		<tr>
			<th>Message:</th>
			<td>{!! $result->message !!}</td>
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
			@allow('qrs.notification.create')
				<a href="{{ route('qrs.notification.create') }}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span> Create</a>
			@endallow
			@allow('qrs.notification.edit')
				<a href="{{ route('qrs.notification.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
			@endallow
			@allow('qrs.notification.delete')
				<a href="{{ route('qrs.notification.delete', $result->id) }}" class="btn btn-danger btn-sm" onclick="return confirmAction('Are you sure?')"><span class="glyphicon glyphicon-remove"></span> Delete</a>
			@endallow
				<a href="{{ route('qrs.notification.index') }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</td>
		</tr>
	</table>

@endsection