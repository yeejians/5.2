@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-user')
@section('header', 'QA Assignment')

@section('details')

	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('qa_id') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label"" for="qa_id">QA PIC:</label>
			<div class="col-md-4">
				<select class="form-control" name="qa_id" id="qa_id">
					<option></option>
					@foreach ($qalist as $qa)
						<option value="{{ $qa->id }}"{!! (old('qa_id', $result->qa_id) == $qa->id ? ' selected="selected"' : '') !!}>{{ $qa->display_name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 col-xs-fixed control-label"" for="add">QA Cc List:</label>
			<div class="col-md-10">
				<select class="form-control populate" multiple name="add[]" id="add">
					@foreach ($lists as $add)
						<option value="{{ $add->id }}">{{ $add->display_name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		@if ($result->defaultqa->count() > 0)
			<div class="form-group">
				<label class="col-md-2 col-xs-fixed control-label"" for="remove">&nbsp;</label>
				<div class="col-md-10">
					<span class="label label-danger">* tick to remove from list</span>
					@foreach ($result->defaultqa as $remove)
						<div class="checkbox">
							<label>
								<input type="checkbox" name="remove[]" value="{{ $remove->id }}"> {{ $remove->display_name }}
							</label>
						</div>
					@endforeach
				</div>
			</div>
		@endif

		<div class="form-group">
			<label class="col-md-2 col-xs-fixed control-label"">&nbsp;</label>
			<div class="col-md-10">
				<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('qrs.assignment.index', $result->id) }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script>
		$(function(){
			$('#add').select2({placeholder: "Enter users"});
			$('#qa_id').select2({placeholder: "Select a QA PIC"});
		});
	</script>

@endsection