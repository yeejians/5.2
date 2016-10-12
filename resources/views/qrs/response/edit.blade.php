@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-share-alt')
@section('header', 'Final Response')

@section('details')

	<form method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="row">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('finalresponse') ? 'has-error' : '' }}">
					<label class="control-label" for="finalresponse">Final response to customer:</label>
					<textarea class="ckeditor" name="finalresponse" id="finalresponse">{{ old('finalresponse', $result->finalresponse) }}</textarea>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
					<a href="{{ route('qrs.response.index', $result->id) }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
				</div>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>

@endsection