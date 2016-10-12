@extends('layouts.default')

@section('content')
	
	<div class="page-header">
		<h3><span class="glyphicon glyphicon-list-alt"></span> STS Report Container</h3>
	</div>

	<div class="list-group">
		@forelse ($result as $key)
			<a href="{{ route($key->routename, $key->id) }}" class="list-group-item">{{ $key->title }}</a>
		@empty
			<a href="" class="list-group-item">No Report</a>
		@endforelse
	</div>

@endsection