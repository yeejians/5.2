@extends('layouts.default')

@section('title')
Mail Setting ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">
	<div class="page-header"><h3><span class="glyphicon glyphicon-th-list"></span> Mail Setting</h3></div>

	<table class="table table-bordered table-striped table-hover sortable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Report Title</th>
				<th>TO</th>
				<th>CC</th>
				<th>Format</th>
				<th>Auto Send</th>
				<th>Created</th>
				<th>Created By</th>
				<th width="150px;">Actions</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($result as $key)
				<tr>
					<td>{{ $key->id }}</td>
					<td>{{ $key->title }}</td>
					<td>
						@if ($key->to->count() > 0)
							@foreach ($key->to as $to)
							<label>{{ $to->display_name }}</label> &lt;{{ $to->email }}&gt;<br />
							@endforeach
						@endif
						@if ($key->exto->count() > 0)
							@foreach ($key->exto as $exto)
							<label>{{ $exto->name }}</label> &lt;{{ $exto->email }}&gt;<br />
							@endforeach
						@endif
					</td>
					<td>
						@if ($key->cc->count() > 0)
							@foreach ($key->cc as $cc)
							<label>{{ $cc->display_name }}</label> &lt;{{ $cc->email }}&gt;<br />
							@endforeach
						@endif
						@if ($key->excc->count() > 0)
							@foreach ($key->excc as $excc)
							<label>{{ $excc->name }}</label> &lt;{{ $excc->email }}&gt;<br />
							@endforeach
						@endif
					</td>
					<td>{{ $key->format }}</td>
					<td>{{ $key->autosend() }}</td>
					<td>{{ $key->created_at }}</td>
					<td>{{ $key->creator() }}</td>
					<td>
						<a href="{{ route('sts.mail.show', $key->id) }}" class="btn btn-primary btn-xs">Details</a>
					</td>
				</tr>
			@empty
				<td colspan="9">No results</td>
			@endforelse
		</tbody>
	</table>

@endsection