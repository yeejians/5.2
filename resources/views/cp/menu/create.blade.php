@extends('layouts.default')

@section('title')
Menu Setting :: Create ::
@parent
@endsection

@section('content')

	<div class="page-header">
		<h3>
			<span class="glyphicon glyphicon-book"></span>
			@if ($parent->id)
				<a href="{{ route('cp.menu.show', $parent->GetRoot()) }}">{{ $parent->GetRootLabel() }}</a>
				@if ($parent->parent_id)
					@foreach ($parent->root->sub as $sub)
						@if (in_array($sub->id, $nav))
							:: <a href="{{ route('cp.menu.show', $sub->id) }}">{{ $sub->label }}</a>
						@endif
					@endforeach
				@endif
				::
			@endif
			Create
		</h3>
	</div>

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		
		<div class="form-group {{ $errors->has('label') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="label">Menu Name</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="label" id="label" value="{{ old('label') }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('route') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="route">Route Name</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="route" id="route" value="{{ old('route') }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('sequence') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="sequence">Menu Sequence</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="sequence" id="sequence" value="{{ old('sequence', $parent->sequence) }}" />
			</div>
		</div>

		@if ($parent->id)
			<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
				<label class="col-md-2 control-label" for="parent_id">Parent Menu</label>
				<div class="col-md-10">
					<select class="form-control" name="parent_id" id="parent_id">
					@if ($parent->hide)
						<option value="{{ $parent->id }}" selected="selected">{{ $parent->label }}</option>
					@elseif ($parent->root_id == 0)
						<option value="{{ $parent->id }}" selected="selected">{{ $parent->label }}</option>
						@foreach ($parent->subMenu as $key)
							<option value="{{ $key->id }}">{{ $key->label }}</option>
						@endforeach
					@else
						<option value="{{ $parent->root_id }}">{{ $parent->root->label }}</option>
						@foreach ($parent->root->subMenu as $key)
							<option value="{{ $key->id }}"{{ ( $key->id == $parent->id ? ' selected="selected"' : '') }}>{{ $key->label }}</option>
						@endforeach
					@endif
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<label class="checkbox-inline"><input type="checkbox" name="publicity" id="publicity" value="1" checked="checked" />everyone can view</label>
					<label class="checkbox-inline"><input type="checkbox" name="hide" id="hide" value="1" checked="checked" />hide from navigation</label>
					<label class="checkbox-inline"><input type="checkbox" name="search" id="search" value="1" />have search field</label>
				</div>
			</div>
		@else
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<label class="checkbox-inline"><input type="checkbox" name="publicity" id="publicity" value="1" checked="checked" />everyone can view</label>
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