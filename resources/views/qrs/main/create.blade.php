@extends('layouts.default')

@section('title')
QR List :: Create ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/redmond/jquery.ui.min.css') }}" rel="stylesheet">

	<div class="page-header"><h3><span class="glyphicon glyphicon-list-alt"></span> New QR</h3></div>

	<form id="form" class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('site_id') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="site_id">Company:</label>
			<div class="col-md-4">
				<select class="form-control populate" name="site_id" id="site_id" readonly="readonly">
					<option value="{{ $site->id }}" selected="selected">{{ $site->name }}</option>
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('refno') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="refno">QR. No.:</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="refno" id="refno" value="{{ $refno }}" readonly="readonly" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('initiator') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="initiator">Initiator:</label>
			<div class="col-md-5">
				<input type="text" class="form-control" name="initiator" id="initiator" value="{{ $user->display_name }}" readonly="readonly" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('saleslist') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="saleslist">Cc List <span class="text-muted"><small>(if any)</small></span>:</label>
			<div class="col-md-9">
				<select class="form-control populate" multiple name="saleslist[]" id="saleslist">
				@foreach ($saleslist as $list)
					<option value="{{ $list->id }}">{{ $list->display_name }}</option>
				@endforeach
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="date">Customer Complaint Date:</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="date" id="date" value="{{ date('d/m/Y') }}" style="position: relative; z-index: 3;" required />
			</div>
		</div>

		<div class="form-group {{ $errors->has('customer_name') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="customer_name">Customer Name:</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required />
			</div>
		</div>

		<div class="form-group {{ $errors->has('nature') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="nature">Nature of Complaint:</label>
			<div class="col-md-9">
				<textarea class="ckeditor" name="nature" id="nature">
					{{ old('nature') }}
				</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('response') ? 'has-error' : '' }}">
			<label class="col-md-3 col-md-fixed control-label" for="response">Immediate Response:</label>
			<div class="col-md-9">
				<textarea class="ckeditor" name="response" id="response">
					{{ old('response') }}
				</textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-md-fixed control-label">&nbsp;</label>
			<div class="col-md-6">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('qrs.index') }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
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
					}
				}
			});
		});
	</script>

@endsection