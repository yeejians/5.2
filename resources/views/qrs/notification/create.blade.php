@extends('layouts.default')

@section('title')
Notification Setting :: Create ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-list-alt"></span> Notification Mail Content :: Create</h3></div>

	<form id="reportform" class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="form-group {{ $errors->has('prefixkey') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="prefixkey">Prefix key</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="prefixkey" id="prefixkey" value="{{ old('prefixkey') }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="name">Name title</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="subject">Subject</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="subject" id="subject" value="{{ old('subject') }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="message">Message</label>
			<div class="col-md-10">
				<textarea class="ckeditor" name="message" id="message" rows="5">
					{{ old('message') }}
				</textarea>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('qrs.notification.index') }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>

@endsection