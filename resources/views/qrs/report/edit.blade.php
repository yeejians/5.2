@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-file')
@section('header', 'Case Leader Report')

@section('details')

	<link href="{{ asset('assets/css/redmond/jquery.ui.min.css') }}" rel="stylesheet">

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('caseleader_finding') ? 'has-error' : '' }}">
			<label class="col-md-3 col-lg-fixed control-label" for="caseleader_finding">Investigation & Finding:</label>
			<div class="col-md-8">
				<textarea class="ckeditor" name="caseleader_finding" id="caseleader_finding">
					{{ old('caseleader_finding', $result->caseleader_finding) }}
				</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('caseleader_rootcause') ? 'has-error' : '' }}">
			<label class="col-md-3 col-lg-fixed control-label" for="caseleader_rootcause">Root Cause:</label>
			<div class="col-md-8">
				<textarea class="ckeditor" name="caseleader_rootcause" id="caseleader_rootcause">
					{{ old('caseleader_rootcause', $result->caseleader_rootcause) }}
				</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('caseleader_corrective') ? 'has-error' : '' }}">
			<label class="col-md-3 col-lg-fixed control-label" for="caseleader_corrective">Corrective / Prevention Action:</label>
			<div class="col-md-8">
				<textarea class="ckeditor" name="caseleader_corrective" id="caseleader_corrective">
					{{ old('caseleader_corrective', $result->caseleader_corrective) }}
				</textarea>
			</div>
		</div>

		<div class="form-group {{ $errors->has('caseleader_completed_at') ? 'has-error' : '' }}">
			<label class="col-md-3 col-lg-fixed control-label" for="caseleader_completed_at">Expected Completion Date:</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="caseleader_completed_at" id="caseleader_completed_at" value="{{ old('caseleader_completed_at', $result->GetExpectedCompleteDate()) }}" style="position: relative; z-index: 3;" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 col-lg-fixed control-label">&nbsp;</label>
			<div class="col-md-9">
				<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('qrs.report.index', $result->id) }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/jquery.ui.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.ui.config.js') }}"></script>
	<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
	<script>
		$(function(){
			$('#caseleader_completed_at').datepicker({
				defaultDate: '-1m',
				dateFormat: 'dd/mm/yy',
				numberOfMonths: 3
			});
		});
	</script>

@endsection