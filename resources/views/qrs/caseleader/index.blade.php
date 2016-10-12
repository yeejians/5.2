@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-user')
@section('header', 'Case Leader Assignment')

@section('details')

	<p>
	@if ($result->IsAdmin() && $result->IsNotLock())
		<a href="{{ route('qrs.caseleader.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		@if ($result->caseleader_id)
			<a href="{{ route('qrs.caseleader.notify', ['caseleader', $result->id]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-envelope"></span> Notify Case Leader</a>
		@endif
		@if ($result->assistant->count() > 0)
			<a href="{{ route('qrs.caseleader.notify', ['assistant', $result->id]) }}" class="btn btn-assign btn-sm"><span class="glyphicon glyphicon-envelope"></span> Notify Assistant</a>
		@endif
	@endif
	</p>

	@if ($result->GetCaseleader())
	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Description of Complaint:</th>
			<td>{{ $result->subject }}</td>
		</tr>
		<tr>
			<th>Classification:</th>
			<td>{{ $result->GetClassification() }}</td>
		</tr>
		<tr>
			<th>Case Leader:</th>
			<td>{{ $result->GetCaseleader() }}</td>
		</tr>
		<tr>
			<th>Assistant:</th>
			<td>
				@foreach ($result->assistant as $assistant)
					{{ $assistant->display_name }}<br />
				@endforeach
			</td>
		</tr>
		<tr>
			<th>Default Cc:</th>
			<td>
				@foreach ($defaultcc as $cc)
					{{ $cc->display_name }}<br />
				@endforeach
			</td>
		</tr>
		<tr>
			<th>Additional Cc:</th>
			<td>
				@foreach ($result->additional as $additional)
					{{ $additional->display_name }}<br />
				@endforeach
			</td>
		</tr>
		<tr>
			<th>Assigned By:</th>
			<td>{{ $result->GetCaseleaderAssignedUser() }}</td>
		</tr>
		<tr>
			<th>Assigned Date:</th>
			<td>{{ $result->GetCaseleaderAssignedDate() }}</td>
		</tr>
	</table>
	@else
		<div class="alert alert-danger" role="alert" align="center">No Case Leader</div>
	@endif

@endsection