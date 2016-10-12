@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-tasks')
@section('header', 'Timeline')

@section('details')

	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Initiation:</th>
			<td>{{ $result->GetQRDate() }}</td>
		</tr>
		<tr>
			<th>QA Assignment:</th>
			<td>{{ $result->GetQAAssignedDate()  }} - {!! $result->GetAssignmentTimeline() !!}</td>
		</tr>
		<tr>
			<th>Case Leader Assignment:</th>
			<td>{{ $result->GetCaseleaderAssignedDate() }} - {!! $result->GetCaseleaderTimeline() !!}</td>
		</tr>
		<tr>
			<th>External Info:</th>
			<td>{{ $result->GetExternalModifiedDate() }} - {!! $result->GetExternalTimeline() !!}</td>
		</tr>
		<tr>
			<th>Case Leader Report:</th>
			<td>{{ $result->GetReportedDate() }} - {!! $result->GetReportTimeline() !!}</td>
		</tr>
		<tr>
			<th>QA Review:</th>
			<td>{{ $result->GetReviewedDate() }} - {!! $result->GetReviewTimeline() !!}</td>
		</tr>
		<tr>
			<th>Final Respond:</th>
			<td>{{ $result->GetRespondDate() }} - {!! $result->GetRespondTimeline() !!}</td>
		</tr>
		@if ($result->GetTotalTimeline())
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<th>Total Day(s) Spent:</th>
			<td>{!! $result->GetTotalTimeline() !!} day(s)</td>
		</tr>
		@endif
		<tr><td colspan="2">&nbsp;</td></tr>
		@if ($result->GetTotalCalander('OFF'))
		<tr>
			<th>In Between Weekend:</th>
			<td>
				<div class="row">
					<div class="col-md-1 col-ns-fixed">{!! $result->GetTotalCalander('OFF') !!}</div>
					<div class="col-md-6">{!! $result->GetTotalCalander('OFF', true) !!}</div>
				</div>
			</td>
		</tr>
		@endif
		@if ($result->GetTotalCalander('PH'))
		<tr>
			<th>In Between Public Holiday:</th>
			<td>
				<div class="row">
					<div class="col-md-1 col-ns-fixed">{!! $result->GetTotalCalander('PH') !!}</div>
					<div class="col-md-6">{!! $result->GetTotalCalander('PH', true) !!}</div>
				</div>
			</td>
		</tr>
		@endif
	</table>

@endsection