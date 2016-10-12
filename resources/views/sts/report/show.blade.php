@extends('layouts.default')

@section('title')
Report Setting :: Show ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-th-list"></span> Report Details</h3></div>

	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Report Title:</th>
			<td>{{ $result->title }}</td>
		</tr>
		<tr>
			<th>File Name:</th>
			<td>{{ $result->filename }}</td>
		</tr>
		<tr>
			<th>File Path Name:</th>
			<td>{{ $result->filepath }}</td>
		</tr>
		<tr>
			<th>Route Name:</th>
			<td>{{ $result->routename }}</td>
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
				<a href="{{ route('sts.report.create') }}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span> Create</a>
				<a href="{{ route('sts.report.edit', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
				<a href="{{ route('sts.report.delete', $result->id) }}" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Delete</a>
				<a href="{{ route('sts.report.index') }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</td>
		</tr>
	</table>

@endsection