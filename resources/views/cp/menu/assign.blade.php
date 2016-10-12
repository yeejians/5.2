@extends('layouts.default')

@section('title')
Menu Setting :: Assign ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">

	<div class="page-header">
		<h3>
			<span class="glyphicon glyphicon-book"></span>
				<a href="{{ route('cp.menu.show', $result->GetRoot()) }}">{{ $result->GetRootLabel() }}</a>
				@if ($result->parent_id)
					@foreach ($result->root->sub as $sub)
						@if (in_array($sub->id, $nav))
							:: <a href="{{ route('cp.menu.show', $sub->id) }}">{{ $sub->label }}</a>
						@endif
					@endforeach
				@endif
				::
			Assign
		</h3>
	</div>

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group">
			<label class="col-md-2 control-label" for="add">Enter User:</label>
			<div class="col-md-10">
				<select class="form-control populate" multiple name="add[]" id="add">
					@foreach ($users as $add)
						<option value="{{ $add->id }}">{{ $add->display_name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		@if ($result->users->count() > 0)
			<div class="form-group">
				<label class="col-md-2 control-label" for="remove">Current User:<BR /><span class="label label-danger">* tick to remove from list</span></label>
				<div class="col-md-10">
					@foreach ($result->users as $remove)
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
			<label class="col-md-2 control-label" for="addG">Enter Group:</label>
			<div class="col-md-10">
				<select class="form-control populate" multiple name="addG[]" id="addG">
					@foreach ($groups as $addG)
						<option value="{{ $addG->id }}">{{ $addG->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		@if ($result->groups->count() > 0)
			<div class="form-group">
				<label class="col-md-2 control-label" for="remG">Current Group:<BR /><span class="label label-danger">* tick to remove from list</span></label>
				<div class="col-md-10">
					@foreach ($result->groups as $remG)
						<div class="checkbox">
							<label>
								<input type="checkbox" name="remG[]" value="{{ $remG->id }}"> {{ $remG->name }}
							</label>
						</div>
					@endforeach
				</div>
			</div>
		@endif

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script>
		$(function(){
			$('#add').select2();
			$('#addG').select2();
		});
	</script>

@endsection