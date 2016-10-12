@extends('layouts.default')

@section('content')

	<link href="{{ asset('assets/css/tree.css') }}" rel="stylesheet">

	<div class="jumbotron">
		<div class="row">
			<div class="col-md-7">
				<h1>Hello, @if(isset($user)) {{ $user->display_name }} @else World!! @endif</h1>
				<p>This is my in-house application portal, nothing more...</p>
				<i>Lam, Yee Kin (Information Technology Department)</i><br /><br />

				<p><a href="{{ route('logout') }}" class="btn btn-primary btn-lg" role="button">Go to Insight Intranet</a></p>
			</div>
			<div class="col-md-5">
				<ul class="tree">
					<li><a href="{{ route('home') }}">Current In-house Application</a>
					@if (!is_null($menu))
						<ul>
							@foreach ($menu as $key)
								<li><a href="{{ route($key->route) }}" target="_blank">{{ $key->label }}</a></li>
							@endforeach
						</ul>
					@endif
					</li>
				</ul>
			</div>
		</div>
	</div>

@endsection