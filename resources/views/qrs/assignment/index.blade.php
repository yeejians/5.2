@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-user')
@section('header', 'QA Assignment')

@section('details')

	<p>
	@if ($result->IsAdmin() && $result->IsNotLock())
		<a href="{{ route('qrs.assignment.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		@if ($result->qa_id)
			<a href="{{ route('qrs.assignment.notify', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-envelope"></span> Notify QA PIC</a>
		@endif
	@endif
	</p>

	@if ($result->GetQAPIC())
	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="150px">QA PIC:</th>
			<td>{{ $result->GetQAPIC() }}</td>
		</tr>
		<tr>
			<th>QA Cc List:</th>
			<td>
				@foreach ($result->defaultqa as $qa)
					{{ $qa->display_name }}<br />
				@endforeach
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<th>Assigned By:</th>
			<td>{{ $result->GetQAAssignedUser() }}</td>
		</tr>
		<tr>
			<th>Assigned Date:</th>
			<td>{{ $result->GetQAAssignedDate() }}</td>
		</tr>
	</table>
	@else
		<div class="alert alert-danger" role="alert" align="center">No QA PIC</div>
	@endif

@endsection