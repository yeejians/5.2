@extends('layouts.default')

@section('title')
Site Setting :: Show ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-flag"></span> Site Details</h3></div>

	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Site Name:</th>
			<td>{{ $result->name }}</td>
		</tr>
		<tr>
			<th>Short Name:</th>
			<td>{{ $result->shortname }}</td>
		</tr>
		<tr>
			<th>SAP Code:</th>
			<td>{{ $result->sapcode }}</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<a href="{{ route('cp.site.create') }}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span> Create</a>
				<a href="{{ route('cp.site.edit', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
				<a href="{{ route('cp.site.delete', $result->id) }}" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Delete</a>
				<a href="{{ route('cp.site.index') }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</td>
		</tr>
	</table>

@endsection