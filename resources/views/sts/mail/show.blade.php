@extends('layouts.default')

@section('title')
Mail Setting :: Content ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-list-alt"></span> {{ $result->title }} :: Mail Content</h3></div>

	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Subject:</th>
			<td>{{ $result->subject }}</td>
		</tr>
		<tr>
			<th>Message:</th>
			<td>{!! $result->message !!}</td>
		</tr>
		<tr>
			<th>To:</th>
			<td>
				@if ($result->to->count() > 0)
					@foreach ($result->to as $to)
						<label>{{ $to->display_name }}</label> &lt;{{ $to->email }}&gt;<br />
					@endforeach
				@endif
				@if ($result->exto->count() > 0)
					@foreach ($result->exto as $exto)
						<label>{{ $exto->name }}</label> &lt;{{ $exto->email }}&gt;<br />
					@endforeach
				@endif
			</td>
		</tr>
		<tr>
			<th>Cc:</th>
			<td>
				@if ($result->cc->count() > 0)
					@foreach ($result->cc as $cc)
						<label>{{ $cc->display_name }}</label> &lt;{{ $cc->email }}&gt;<br />
					@endforeach
				@endif
				@if ($result->excc->count() > 0)
					@foreach ($result->excc as $excc)
						<label>{{ $excc->name }}</label> &lt;{{ $excc->email }}&gt;<br />
					@endforeach
				@endif
			</td>
		</tr>
		<tr>
			<th>Auto send mail:</th>
			<td>{{ $result->autosend() }}</td>
		</tr>
		<tr>
			<th>Output format:</th>
			<td>{{ $result->format }}</td>
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
				<a href="{{ route('sts.mail.setting', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> Settings</a>
				<a href="{{ route('sts.mail.recipient', ['to', $result->id]) }}" class="btn btn-info btn-sm">To</a>
				<a href="{{ route('sts.mail.recipient', ['cc', $result->id]) }}" class="btn btn-warning btn-sm">CC</a>
				<a href="{{ route('sts.mail.index') }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</td>
		</tr>
	</table>

@endsection