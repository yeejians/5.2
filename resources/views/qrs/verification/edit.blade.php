@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-ok-circle')
@section('header', 'QA Verification')

@section('details')

	<form method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="row">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('closed') ? 'has-error' : '' }}">
					<label class="control-label" for="closed">Case Status:</label>
					<label class="radio-inline"><input type="radio" name="closed" id="closed_0" value="0"{!! (old('closed', $result->closed) == 0 ? ' checked="checked"' : '') !!} /> Opened</label>
					<label class="radio-inline"><input type="radio" name="closed" id="closed_1" value="1"{!! (old('closed', $result->closed) == 1 ? ' checked="checked"' : '') !!} /> Closed</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('locked') ? 'has-error' : '' }}">
					<label class="control-label" for="locked">Lock Status:</label>
					<label class="radio-inline"><input type="radio" name="locked" id="locked_0" value="0"{!! (old('locked', $result->locked) == 0 ? ' checked="checked"' : '') !!} /> Unlock</label>
					<label class="radio-inline"><input type="radio" name="locked" id="locked_1" value="1"{!! (old('locked', $result->locked) == 1 ? ' checked="checked"' : '') !!} /> Lock</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('verification') ? 'has-error' : '' }}">
					<label class="control-label" for="verification">Remarks of implementation and effectiveness:</label>
					<textarea class="ckeditor" name="verification" id="verification">{{ old('verification', $result->verification) }}</textarea>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
					<a href="{{ route('qrs.verification.index', $result->id) }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
				</div>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
	<script>
		$(function(){
			$('#closed_1').on('click', function(){
				$('#locked_1').prop('checked', true);
			});
		});
	</script>

@endsection