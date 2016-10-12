@extends('layouts.default')

@section('title')
Report Setting :: Edit ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-th-list"></span> Edit Report</h3></div>

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="title">Report Title</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="title" id="title" value="{{ old('title', $result->title) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('filename') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="filename">File Name</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="filename" id="filename" value="{{ old('filename', $result->filename) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('filepath') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="filepath">File Path</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="filepath" id="filepath" value="{{ old('filepath', $result->filepath) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('routename') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="routename">Route Name</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="routename" id="routename" value="{{ old('routename', $result->routename) }}" />
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('sts.report.show', $result->id) }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>

	</form>

@endsection