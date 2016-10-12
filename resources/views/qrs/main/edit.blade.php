@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon-list-alt')
@section('header', 'Edit')

@section('details')

	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/redmond/jquery.ui.min.css') }}" rel="stylesheet">

	<form id="form" class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('site_id') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="site_id">Company:</label>
			<div class="col-md-5">
				<select class="form-control populate" name="site_id" id="site_id" readonly="readonly">
					<option value="{{ $result->site->id }}" selected="selected">{{ $result->site->name }}</option>
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('refno') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="refno">QR. No.:</label>
			<div class="col-md-5">
				<input type="text" class="form-control" name="refno" id="refno" value="{{ $result->refno }}" readonly="readonly" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('initiator') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="initiator">Initiator:</label>
			<div class="col-md-5">
				<input type="text" class="form-control" name="initiator" id="initiator" value="{{ $result->creator() }}" readonly="readonly" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('saleslist') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="saleslist">Cc List <span class="text-muted"><small>(if any)</small></span>:</label>
			<div class="col-md-6">
				<select class="form-control populate" multiple name="saleslist[]" id="saleslist">
				@foreach ($saleslist as $list)
					<option value="{{ $list->id }}">{{ $list->display_name }}</option>
				@endforeach
				</select>
				@if ($result->sales->count() > 0)
					<span class="label label-danger">* tick to remove from list</span><br />
					@foreach ($result->sales as $sales)
						<div class="checkbox"><label><input type="checkbox" name="remove[]" value="{{ $sales->id }}" /> {{ $sales->display_name }}</label></div>
					@endforeach
				@endif
			</div>
		</div>

		<div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="date">Customer Complaint Date:</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="date" id="date" value="{{ $result->GetComplaintDate() }}" style="position: relative; z-index: 3;" required />
			</div>
		</div>

		<div class="form-group {{ $errors->has('sono') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="sono">Sales Contract / Order No.:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="sono" id="sono" rows="6" required>{{ old('sono', $result->sono) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('customer_name') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="customer_name">Customer Name:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="customer_name" id="customer_name" rows="6" required>{{ old('customer_name', $result->customer_name) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="customer_id">Customer ID:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="customer_id" id="customer_id" rows="6" required>{{ old('customer_id', $result->customer_id) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="country_id">Customer Country:</label>
			<div class="col-md-3">
				<select class="form-control" name="country_id" id="country_id" required>
					<option></option>
					@foreach ($countries as $country)
						<option value="{{ $country->id }}"{!! (old('country_id', $result->country_id) == $country->id ? ' selected="selected"' : '') !!}>{{ $country->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('batch') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="batch">Batch No.:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="batch" id="batch" rows="6" required>{{ old('batch', $result->batch) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('outbound') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="outbound">Outbound No.:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="outbound" id="outbound" rows="6" required>{{ old('outbound', $result->outbound) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('production_at') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="production_at">Production Date:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="production_at" id="production_at" rows="6" required>{{ old('production_at', $result->production_at) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('dispatch_at') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="dispatch_at">Dispatch Date:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="dispatch_at" id="dispatch_at" rows="6" required>{{ old('dispatch_at', $result->dispatch_at) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('arrival_at') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="arrival_at">Arrival Date:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="arrival_at" id="arrival_at" rows="6" required>{{ old('arrival_at', $result->arrival_at) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('incoterm') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="incoterm">Incoterm:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="incoterm" id="incoterm" rows="6" required>{{ old('incoterm', $result->incoterm) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('product_caiscode') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="product_caiscode">Product CAIS Code:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="product_caiscode" id="product_caiscode" rows="6" required>{{ old('product_caiscode', $result->product_caiscode) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('product_name') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="product_name">Product Name:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="product_name" id="product_name" rows="6" required>{{ old('product_name', $result->product_name) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('product_category') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="product_category">Product Category:</label>
			<div class="col-md-9">
				<label class="radio-inline">
					<input type="radio" name="product_category" id="product_category_1" value="Commodity"{!! (old('product_category', $result->product_category) == 'Commodity' ? ' checked="checked"' : '') !!} /> Commodity
				</label>
				<label class="radio-inline">
					<input type="radio" name="product_category" id="product_category_0" value="Specialty"{!! (old('product_category', $result->product_category) == 'Specialty' ? ' checked="checked"' : '') !!} /> Specialty
				</label>
			</div>
		</div>

		<div class="form-group {{ $errors->has('container') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="container">Container No.:</label>
			<div class="col-md-6">
				<textarea class="form-control" name="container" id="container" rows="6" required>{{ old('container', $result->container) }}</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('reefer') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="reefer">Reefer Container:</label>
			<div class="col-md-9">
				<label class="radio-inline"><input type="radio" name="reefer" id="reefer_1" value="1"{!! (old('reefer', $result->reefer) == 1 ? ' checked="checked"' : '') !!} /> Yes</label>
				<label class="radio-inline"><input type="radio" name="reefer" id="reefer_0" value="0"{!! (old('reefer', $result->reefer) == 0 ? ' checked="checked"' : '') !!} /> No</label>
			</div>
		</div>

		<div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="quantity">Affected Quantity (MT):</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="quantity" id="quantity" value="{{ old('quantity', $result->quantity) }}" required />
			</div>
		</div>

		<div class="form-group {{ $errors->has('pack_id') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="pack_id">Packing Type:</label>
			<div class="col-md-3">
				<select class="form-control" name="pack_id" id="pack_id" required>
					<option></option>
					@foreach ($packing as $pack)
						<option value="{{ $pack->id }}"{!! (old('pack_id', $result->pack_id) == $pack->id ? ' selected="selected"' : '') !!}>{{ $pack->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('size') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="size">Packing Size (KG):</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="size" id="size" value="{{ old('size', $result->size) }}" required />
			</div>
		</div>

		<div class="form-group {{ $errors->has('stuff_id') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="stuff_id">Stuffing Type:</label>
			<div class="col-md-3">
				<select class="form-control" name="stuff_id" id="stuff_id" required>
					<option></option>
					@foreach ($stuffing as $stuff)
						<option value="{{ $stuff->id }}"{!! (old('stuff_id', $result->stuff_id) == $stuff->id ? ' selected="selected"' : '') !!}>{{ $stuff->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('nature') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="nature">Nature of Complaint:</label>
			<div class="col-md-8">
				<textarea class="ckeditor" name="nature" id="nature">
					{{ old('nature', $result->nature) }}
				</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('response') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="response">Immediate Response:</label>
			<div class="col-md-8">
				<textarea class="ckeditor" name="response" id="response">
					{{ old('response', $result->response) }}
				</textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-md-fixed control-label">&nbsp;</label>
			<div class="col-md-6">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('qrs.show', $result->id) }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>

	</form>

	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.ui.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.ui.config.js') }}"></script>
	<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.validate.config.js') }}"></script>
	<script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
	<script>
		$(function(){
			$('#date').datepicker({
				defaultDate: '-1m',
				dateFormat: 'dd/mm/yy',
				numberOfMonths: 3
			});
			
			$('#saleslist').select2();

			$('#country_id').select2({placeholder: "-- Please Select --"});
			$('#stuff_id').select2({placeholder: "-- Please Select --"});
			$('#pack_id').select2({placeholder: "-- Please Select --"});

			$('#site_id').select2();
			$('#site_id').select2("readonly", true);

			$('#form').validate({
				ignore: [],
				rules: {
					nature: {
						required: function(){
							CKEDITOR.instances.nature.updateElement();
						}
					},
					response: {
						required: function(){
							CKEDITOR.instances.response.updateElement();
						}
					}
				},
				messages: {
					country_id: {
						required: "this field is required"
					},
					pack_id: {
						required: "this field is required"
					},
					stuff_id: {
						required: "this field is required"
					}
				}
			});
		});
	</script>

@endsection