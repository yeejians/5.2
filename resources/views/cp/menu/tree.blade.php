@extends('layouts.default')

@section('title')
Menu Setting :: Tree ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/tree.css') }}" rel="stylesheet">

	<div class="page-header">
		<h3>
			<span class="glyphicon glyphicon-book"></span>
			@if ($result->root_id)
				{{ $result->root->label }} ::
			@else
				{{ $result->label }} ::
			@endif
			Tree
		</h3>
	</div>

	<div class="jumbotron">
		<ul class="tree">
			{!! $tree !!}
		</ul>
	</div>

@endsection