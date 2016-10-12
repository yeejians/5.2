@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-user')
@section('header', 'Case Leader Assignment')

@section('details')

	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
			<label class="col-md-2 col-md-fixed control-label" for="subject">Description of Complaint:</label>
			<div class="col-md-6">
				<input type="text" class="form-control" name="subject" id="subject" value="{{ old('subject', $result->subject) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('classification_id') ? 'has-error' : '' }}">
			<label class="col-md-2 col-md-fixed control-label" for="classification_id">Classification:</label>
			<div class="col-md-4">
				<select class="form-control" name="classification_id" id="classification_id">
					<option></option>
					@foreach ($classes as $class)
						<option value="{{ $class->id }}"{!! (old('classification_id', $result->classification_id) == $class->id ? ' selected="selected"' : '') !!}>{{ $class->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('caseleader_id') ? 'has-error' : '' }}">
			<label class="col-md-2 col-md-fixed control-label" for="caseleader_id">Case Leader:</label>
			<div class="col-md-4">
				<select class="form-control" name="caseleader_id" id="caseleader_id">
					<option></option>
					@foreach ($caseleaders->user as $caseleader)
						<option value="{{ $caseleader->id }}"{!! (old('caseleader_id', $result->caseleader_id) == $caseleader->id ? ' selected="selected"' : '') !!}>{{ $caseleader->display_name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 col-md-fixed control-label" for="assistant">Assistant:</label>
			<div class="col-md-10">
				<select class="form-control populate" multiple name="assistant[]" id="assistant">
					@foreach ($assistants as $assistant)
						<option value="{{ $assistant->id }}">{{ $assistant->display_name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		@if ($result->assistant->count() > 0)
			<div class="form-group">
				<label class="col-md-2 col-md-fixed control-label" for="removeassistant">&nbsp;</label>
				<div class="col-md-10">
					<span class="label label-danger">* tick to remove from list</span>
					@foreach ($result->assistant as $removeassistant)
						<div class="checkbox">
							<label>
								<input type="checkbox" name="removeassistant[]" value="{{ $removeassistant->id }}"> {{ $removeassistant->display_name }}
							</label>
						</div>
					@endforeach
				</div>
			</div>
		@endif

		<div class="form-group">
			<label class="col-md-2 col-md-fixed control-label" for="additional">Additional Cc:</label>
			<div class="col-md-10">
				<select class="form-control populate" multiple name="additional[]" id="additional">
					@foreach ($additionals as $additional)
						<option value="{{ $additional->id }}">{{ $additional->display_name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		@if ($result->additional->count() > 0)
			<div class="form-group">
				<label class="col-md-2 col-md-fixed control-label" for="removeadditional">&nbsp;</label>
				<div class="col-md-10">
					<span class="label label-danger">* tick to remove from list</span>
					@foreach ($result->additional as $removeadditional)
						<div class="checkbox">
							<label>
								<input type="checkbox" name="removeadditional[]" value="{{ $removeadditional->id }}"> {{ $removeadditional->display_name }}
							</label>
						</div>
					@endforeach
				</div>
			</div>
		@endif

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('qrs.caseleader.index', $result->id) }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script>
		$(function(){
			$('#classification_id').select2();
			$('#additional').select2({placeholder: "Enter additional cc"});
			$('#assistant').select2({placeholder: "Enter assistant"});
			$('#caseleader_id').select2({placeholder: "Select a case leader"});
		});
	</script>

@endsection