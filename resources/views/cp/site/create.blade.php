@extends('layouts.default')

@section('title')
Site Setting :: Create ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-flag"></span> Create</h3></div>

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="name">Site Name</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('shortname') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="shortname">Short Name</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="shortname" id="shortname" value="{{ old('shortname') }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('sapcode') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="sapcode">SAP Code</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="sapcode" id="sapcode" value="{{ old('sapcode') }}" />
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('cp.site.index') }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>

	</form>

@endsection