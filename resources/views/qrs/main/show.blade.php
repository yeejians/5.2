@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon-list-alt')
@section('header', 'QR Details')

@section('details')

	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">

	<p>
	@if (($result->IsInitiator() || $result->IsSalesCc()) && $result->IsNotLock())
		<a href="{{ route('qrs.edit', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		<a href="{{ route('qrs.attachment', $result->id) }}" class="btn btn-success btn-sm" id="uploader"><span class="glyphicon glyphicon-file"></span> Add Attachment</a>
		<a href="{{ route('qrs.notify', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-envelope"></span> Send Notification</a>
	@endif
	</p>

	<table class="table table-condensed table-striped table-horizontal">
		<tr>
			<th width="200px">Company:</th>
			<td>{{ $result->site->name }}</td>
		</tr>
		<tr>
			<th>QR. Ref. No.:</th>
			<td>{{ $result->refno }}</td>
		</tr>
		<tr>
			<th>Initiator (ASM):</th>
			<td>{{ $result->creator() }}</td>
		</tr>
		@if (count($result->sales) > 0)
		<tr>
			<th>Cc list:</th>
			<td>
				@foreach ($result->sales as $sales)
					{{ $sales->display_name }}<br />
				@endforeach
			</td>
		</tr>
		@endif
		<tr>
			<th>Initiated Date:</th>
			<td>{{ $result->GetQRDate() }}</td>
		</tr>
		<tr>
			<th>Customer Complaint Date:</th>
			<td>{{ $result->GetComplaintDate() }}</td>
		</tr>
		<tr>
			<th>Sales Contract / Order No.:</th>
			<td>{{ $result->sono }}</td>
		</tr>
		<tr>
			<th>Customer Name:</th>
			<td>{{ $result->customer_name }}</td>
		</tr>
		<tr>
			<th>Customer ID:</th>
			<td>{{ $result->customer_id }}</td>
		</tr>
		<tr>
			<th>Customer Country:</th>
			<td>{{ $result->GetCountry() }}</td>
		</tr>
		
		<tr>
			<th>Batch No.:</th>
			<td>{{ $result->batch }}</td>
		</tr>
		<tr>
			<th>Outbound No.:</th>
			<td>{{ $result->outbound }}</td>
		</tr>
		<tr>
			<th>Production Date:</th>
			<td>{{ $result->production_at }}</td>
		</tr>
		<tr>
			<th>Dispatch Date:</th>
			<td>{{ $result->dispatch_at }}</td>
		</tr>
		<tr>
			<th>Arrival Date:</th>
			<td>{{ $result->arrival_at }}</td>
		</tr>
		<tr>
			<th>Incoterm:</th>
			<td>{{ $result->incoterm }}</td>
		</tr>
		<tr>
			<th>Product Name:</th>
			<td>{{ $result->product_name }}</td>
		</tr>
		<tr>
			<th>Product Category:</th>
			<td>{{ $result->product_category }}</td>
		</tr>
		<tr>
			<th>Product CAIS Code:</th>
			<td>{{ $result->product_caiscode }}</td>
		</tr>
		<tr>
			<th>Container No.:</th>
			<td>{{ $result->container }}</td>
		</tr>
		<tr>
			<th>Reefer Container:</th>
			<td>{{ $result->GetReefer() }}</td>
		</tr>
		<tr>
			<th>Affected Quantity (MT):</th>
			<td>{{ $result->quantity }}</td>
		</tr>
		<tr>
			<th>Packing Type:</th>
			<td>{{ $result->GetPacking() }}</td>
		</tr>
		<tr>
			<th>Packing Size (KG):</th>
			<td>{{ $result->size }}</td>
		</tr>
		<tr>
			<th>Stuffing Type:</th>
			<td>{{ $result->GetStuffing() }}</td>
		</tr>
		<tr>
			<th>Nature of Complaint:</th>
			<td>{!! $result->nature !!}</td>
		</tr>
		<tr>
			<th>Immediate Responses:</th>
			<td>{!! $result->response !!}</td>
		</tr>
		@if ($result->fileInitiation->count() > 0)
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<th>Attachment:</th>
			<td>
				@foreach ($result->fileInitiation as $file)
					{!! $file->getblock($result->IsNotLock())  !!}
				@endforeach
			</td>
		</tr>
		@endif
	</table>

	<script src="{{ asset('assets/js/jquery.magnific.popup.min.js') }}"></script>
	<script>
		$(function(){
			$('#uploader').on('click', function(){
				Uploader($(this).attr('href'));
				return false;
			});

			Getlightbox();
		});
	</script>

@endsection