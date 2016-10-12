@extends('emails.layout')

@section('mailbody')

	{!! $content !!}

	<table border="1">
		<tr>
			<th>QR No.</th>
			<th>Date</th>
			<th>Customer Name</th>
			<th>Complaint</th>
			<th>Pending At</th>
			<th>Pending Days</th>
		</tr>
		@foreach ($result as $key)
		<tr>
			<td><a href="{{ route('qrs.show', $key->id) }}">{{ $key->refno }}</a></td>
			<td>{{ $key->GetComplaintDate() }}</td>
			<td>{{ $key->customer_name }}</td>
			<td>{{ $key->subject }}</td>
			<td>{!! $key->GetLink() !!}</td>
			<td>{{ $key->pending_day }}</td>
		</tr>
		@endforeach
	</table>

@endsection