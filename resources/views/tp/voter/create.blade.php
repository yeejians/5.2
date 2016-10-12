@extends('layouts.default')

@section('title')
Voter Setting :: Create ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">

	<div class="page-header"><h3><span class="glyphicon glyphicon-user"></span> Create</h3></div>

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="department">Function Department</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="department" id="department" value="{{ old('department') }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="user_id">Representative</label>
			<div class="col-md-4">
				<select class="form-control" name="user_id" id="user_id">
					<option></option>
					@foreach ($users as $user)
						<option value="{{ $user->id }}" {{ ( $user->id == old('user_id') ? ' selected="selected"' : '') }}>{{ $user->display_name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('site_id') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="site_id">Site</label>
			<div class="col-md-4">
				<select class="form-control" name="site_id" id="site_id">
					<option></option>
					@foreach ($sites as $site)
						<option value="{{ $site->id }}" {{ ( $site->id == old('site_id') ? ' selected="selected"' : '') }}>{{ $site->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('tp.voter.index') }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>

	</form>

	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script>
		$(function(){
			$('#user_id').select2({
				placeholder: "Select a Representative",
				allowClear: true,
				minimumInputLength: 2
			});

			$('#site_id').select2();
		});
	</script>

@endsection