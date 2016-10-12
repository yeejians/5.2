@extends('layouts.default')

@section('title')
Packing Setting :: Show ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-inbox"></span> Packing Type Details</h3></div>

	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Packing Type Name:</th>
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
			@allow('qrs.packing.create')
				<a href="{{ route('qrs.packing.create') }}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span> Create</a>
			@endallow
			@allow('qrs.packing.edit')
				<a href="{{ route('qrs.packing.edit', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
			@endallow
			@allow('qrs.packing.delete')
				<a href="{{ route('qrs.packing.delete', $result->id) }}" class="btn btn-danger btn-sm" onclick="return confirmAction('Are you sure?')"><span class="glyphicon glyphicon-remove"></span> Delete</a>
			@endallow
				<a href="{{ route('qrs.packing.index') }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</td>
		</tr>
	</table>

@endsection