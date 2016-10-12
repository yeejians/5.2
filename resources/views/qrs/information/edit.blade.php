@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-comment')
@section('header', 'QA Information')

@section('details')

	<form method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="row">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('information') ? 'has-error' : '' }}">
					<label class="control-label" for="information">Information collection:</label>
					<textarea class="ckeditor" name="information" id="information">{{ old('information', $result->information) }}</textarea>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
					<a href="{{ route('qrs.information.index', $result->id) }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
				</div>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>

@endsection