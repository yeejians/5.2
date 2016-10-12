@extends('layouts.default')

@section('title')
Menu Setting :: Edit ::
@parent
@endsection

@section('content')

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
			Edit
		</h3>
	</div>

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		
		<div class="form-group {{ $errors->has('label') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="label">Menu Name</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="label" id="label" value="{{ old('label', $result->label) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('route') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="route">Route Name</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="route" id="route" value="{{ old('route', $result->route) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('sequence') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="sequence">Menu Sequence</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="sequence" id="sequence" value="{{ old('sequence', $result->sequence) }}" />
			</div>
		</div>

		@if ($result->parent_id)
			<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
				<label class="col-md-2 control-label" for="parent_id">Parent Menu</label>
				<div class="col-md-10">
					<select class="form-control" name="parent_id" id="parent_id">
					@if ($result->parent->hide)
						<option value="{{ $result->parent_id }}">{{ $result->parent->label }}</option>
					@else
						<option value="{{ $result->root_id }}">{{ $result->root->label }}</option>
						@foreach ($result->root->subMenu as $key)
							@if ($key->id != $result->id)
								<option value="{{ $key->id }}"{{ ( $key->id == $result->parent_id ? ' selected="selected"' : '') }}>{{ $key->label }}</option>
							@endif
						@endforeach
					@endif
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<label class="checkbox-inline">
						<input type="checkbox" name="publicity" id="publicity" value="1"{{ ( $result->publicity ? ' checked="checked"' : '' ) }} />everyone can view
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" name="hide" id="hide" value="1"{{ ( $result->hide ? ' checked="checked"' : '' ) }} />hide from navigation
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" name="search" id="search" value="1"{{ ( $result->search ? ' checked="checked"' : '' ) }} />have search field
					</label>
				</div>
			</div>
		@else
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<label class="checkbox-inline">
						<input type="checkbox" name="publicity" id="publicity" value="1"{{ ( $result->publicity ? ' checked="checked"' : '' ) }} />everyone can view
					</label>
				</div>
			</div>
		@endif

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
			</div>
		</div>

	</form>

@endsection