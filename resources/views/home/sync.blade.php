@extends('layouts.default')

@section('title')
Synchronizing Windows ID ::
@parent
@endsection

@section('content')

	<div class="jumbotron" align="center">
		<p id="message">Synchronizing user data, please wait...</p>
		<img src="{{ asset('assets/img/preloader.gif') }}"/>
	</div>

	<script src="{{ asset('assets/js/admin.js') }}"></script>
	@if(!empty($import))
		<script>SyncAD('{{ config('app.sync') }}/{{ $username }}/1/sync', '{{ $redirect }}')</script>
	@endif

@endsection