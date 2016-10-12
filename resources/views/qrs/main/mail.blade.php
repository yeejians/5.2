@extends('emails.layout')

@section('mailbody')

	{!! $content !!}

	<table>
		<tr>
			<td class="four"><b>QR Ref. No.</b></td>
			<td>: <a href="{{ $result->GetURL() }}">{{ $result->refno }}</a></td>
		</tr>
		<tr>
			<td><b>QR Date</b></td>
			<td>: {{ $result->GetQRDate() }}</td>
		</tr>
		<tr>
			<td><b>Customer Complaint Date</b></td>
			<td>: {{ $result->GetComplaintDate() }}</td>
		</tr>
		<tr>
			<td><b>Sales Contract / Order No.</b></td>
			<td>: {{ $result->sono }}</td>
		</tr>
		<tr>
			<td><b>Customer Name</b></td>
			<td>: {{ $result->customer_name }}</td>
		</tr>
		@if ($result->notification_id == 1)
		<tr>
			<td><b>Customer ID</b></td>
			<td>: {{ $result->customer_id }}</td>
		</tr>
		<tr>
			<td><b>Country</b></td>
			<td>: {{ $result->GetCountry() }}</td>
		</tr>
		<tr>
			<td><b>Batch No.</b></td>
			<td>: {{ $result->batch }}</td>
		</tr>
		<tr>
			<td><b>Outbound No.</b></td>
			<td>: {{ $result->outbound }}</td>
		</tr>
		<tr>
			<td><b>Production Date</b></td>
			<td>: {{ $result->production_at }}</td>
		</tr>
		<tr>
			<td><b>Dispatch Date</b></td>
			<td>: {{ $result->dispatch_at }}</td>
		</tr>
		<tr>
			<td><b>Arrival Date</b></td>
			<td>: {{ $result->arrival_at }}</td>
		</tr>
		<tr>
			<td><b>Incoterm</b></td>
			<td>: {{ $result->incoterm }}</td>
		</tr>
		<tr>
			<td><b>Product Name</b></td>
			<td>: {{ $result->product_name }}</td>
		</tr>
		<tr>
			<td><b>Product Category</b></td>
			<td>: {{ $result->product_category }}</td>
		</tr>
		<tr>
			<td><b>Product CAIS Code</b></td>
			<td>: {{ $result->product_caiscode }}</td>
		</tr>
		<tr>
			<td><b>Container No</b></td>
			<td>: {{ $result->container }}</td>
		</tr>
		<tr>
			<td><b>Reefer Container</b></td>
			<td>: {{ $result->GetReefer() }}</td>
		</tr>
		<tr>
			<td><b>Affected Quantity (MT)</b></td>
			<td>: {{ $result->quantity }}</td>
		</tr>
		<tr>
			<td><b>Packing Type</b></td>
			<td>: {{ $result->GetPacking() }}</td>
		</tr>
		<tr>
			<td><b>Packing Size (KG)</b></td>
			<td>: {{ $result->size }}</td>
		</tr>
		<tr>
			<td><b>Stuffing Type</b></td>
			<td>: {{ $result->GetStuffing() }}</td>
		</tr>
	</table><br />
	<table>
		<tr>
			<td>
				<b>Nature of Complaint</b>:<br />
				{!! $result->nature !!}
			</td>
		</tr>
		<tr>
			<td>
				<b>Immediate Responses</b>:<br />
				{!! $result->response !!}
			</td>
		</tr>
		@endif
	</table>

@endsection