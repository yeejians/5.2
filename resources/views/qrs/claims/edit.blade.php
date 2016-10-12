@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-usd')
@section('header', 'Cost of claims')

@section('details')

	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('claimstype_id') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label" for="claimstype_id">Claims Type:</label>
			<div class="col-md-3">
				<select class="form-control" name="claimstype_id" id="claimstype_id">
					<option></option>
					@foreach ($claimstype as $claimtype)
						<option value="{{ $claimtype->id }}"{!! (old('claimstype_id', $claim->claimtype_id) == $claimtype->id ? ' selected="selected"' : '') !!}>{{ $claimtype->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('document_id') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label" for="document_id">Document Type:</label>
			<div class="col-md-3">
				<select class="form-control" name="document_id" id="document_id">
					<option></option>
					@foreach ($documents as $document)
						<option value="{{ $document->id }}"{!! (old('document_id', $claim->document_id) == $document->id ? ' selected="selected"' : '') !!}>{{ $document->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('refno') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label" for="refno">Ref. No.:</label>
			<div class="col-md-3">
				<input type="text" class="form-control" name="refno" id="refno" value="{{ old('refno', $claim->refno) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('currency_id') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label" for="currency_id">Currency:</label>
			<div class="col-md-3">
				<select class="form-control" name="currency_id" id="currency_id">
					<option></option>
					@foreach ($currencies as $currency)
						<option value="{{ $currency->id }}"{!! (old('currency_id', $claim->currency_id) == $currency->id ? ' selected="selected"' : '') !!}>{{ $currency->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('rate') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label" for="rate">Exchange Rate:</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="rate" id="rate" value="{{ old('rate', $claim->rate) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label" for="amount">Amount:</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="amount" id="amount" value="{{ old('amount', $claim->amount) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('local') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label" for="local">Amount (RM):</label>
			<div class="col-md-2">
				<p class="form-control-static" id="local">{{ $claim->local }}</p>
			</div>
		</div>

		<div class="form-group {{ $errors->has('remarks') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label" for="remarks">Remarks:</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="remarks" id="remarks" value="{{ old('remarks', $claim->remarks) }}" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 col-xs-fixed control-label">&nbsp;</label>
			<div class="col-md-6">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('qrs.claims.index', $result->id) }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>

	</form>

	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script>
		$(function(){
			$('#claimstype_id').select2();
			$('#document_id').select2();
			$('#currency_id').select2();

			$('#rate').on('change', function(){
				GetLocalAmount();
			});

			$('#amount').on('change', function(){
				GetLocalAmount();
			});
		});

		function GetLocalAmount()
		{
			var localamt = $('#rate').val() * $('#amount').val();

			$('#local').text(localamt.toFixed(3));
		}
	</script>

@endsection