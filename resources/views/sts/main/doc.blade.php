@extends('layouts.default')

@section('title')
{{ $result->title }} ::
@parent
@endsection

@section('content')
	
	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/redmond/jquery.ui.min.css') }}" rel="stylesheet">

	<form id="reportform" class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<div class="page-header">
			<h3><span class="glyphicon glyphicon-list-alt"></span> {{ $result->title }}</h3>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		</div>

		@if ($result->id == 2)
			<div class="form-group {{ $errors->has('fromDate') ? 'has-error' : '' }}">
				<label class="col-md-2 control-label" for="fromDate">From Date</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="fromDate" id="fromDate" value="{{ old('fromDate', $fromDate->format('d/m/Y')) }}" />
				</div>
			</div>

			<div class="form-group {{ $errors->has('toDate') ? 'has-error' : '' }}">
				<label class="col-md-2 control-label" for="toDate">To Date</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="toDate" id="toDate" value="{{ old('toDate', $toDate->format('d/m/Y')) }}" />
				</div>
			</div>
		@endif

		<div class="form-group {{ $errors->has('ext') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="ext">Output Format</label>
			<div class="col-md-2">
				<label class="radio-inline"><input type="radio" name="ext" id="pdf" value="pdf" checked> PDF</label>
				<label class="radio-inline"><input type="radio" name="ext" id="xls" value="xls"> Excel</label>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Submit</button>
				<button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Reset</button>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.ui.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.ui.config.js') }}"></script>
	<script>
		$(function(){
			$('#fromDate').datepicker({
				defaultDate: '-1m',
				dateFormat: 'dd/mm/yy',
				numberOfMonths: 3,
				onClose: function(selectedDate){
					$('#toDate').datepicker('option', 'minDate', selectedDate);
				}
			});

			$('#toDate').datepicker({
				defaultDate: '-1m',
				dateFormat: 'dd/mm/yy',
				numberOfMonths: 3,
				onClose: function(selectedDate){
					$('#fromDate').datepicker('option', 'maxDate', selectedDate);
				}
			});
		});
	</script>

	@if ($filename)
	<script src="{{ asset('assets/js/jquery.popupwindow.js') }}"></script>
	<script>
		$(function(){
			$.popupWindow('{{ route('sts.read', $filename) }}', {
				width: 1024,
				height: 768,
				center: 'screen'
			});
		});
	</script>
	@endif

@endsection