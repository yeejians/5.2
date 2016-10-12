@extends('layouts.default')

@section('title')
Control Panel ::
@parent
@endsection

@section('content')

	<div class="page-header">
		<h3><span class="glyphicon glyphicon-list-alt"></span> Menu List</h3>
	</div>

	<div class="list-group">
	@if (!is_null($result))
		@foreach ($result->root->subMenu as $key)
			<a href="{{ route($key->route) }}" class="list-group-item">{{ $key->label }}</a>
		@endforeach
	@else
		<a href="{{ route('cp') }}" class="list-group-item">No Menu</a>
	@endif
	</div>

@endsection