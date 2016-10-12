@extends('layouts.default')

@section('title')
{{ $result->refno }} ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/bootstrap-vertical-tabs.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bootstrap-tabs-custom.css') }}" rel="stylesheet">

	<div class="page-header">
		<h3>
			<span class="glyphicon @yield('glyphicon')"></span>
				@yield('header') - {{ $result->refno }}
			<span class="text-muted">{{ $result->GetClosed() }}</span>
		</h3>
	</div>

	<div class="row tabbable-vertical">
		<div class="col-md-2 tab-nav-vertical">
			<ul class="nav nav-tabs tabs-left">
				<li><a href="{{ session('redirect') }}">Back to Main List</a></li>
				<li{!! ($result->tab == 'initiation'	? ' class="active"' : '') !!}><a href="{{ route('qrs.show',					$result->id) }}">Initiation</a></li>
				<li{!! ($result->tab == 'assignment'	? ' class="active"' : '') !!}><a href="{{ route('qrs.assignment.index',		$result->id) }}">Assign QA</a></li>
				<li{!! ($result->tab == 'caseleader'	? ' class="active"' : '') !!}><a href="{{ route('qrs.caseleader.index',		$result->id) }}">Assign Case Leader</a></li>
				<li{!! ($result->tab == 'feedback'		? ' class="active"' : '') !!}><a href="{{ route('qrs.feedback.index',		$result->id) }}">My Feedback</a></li>
				<li{!! ($result->tab == 'external'		? ' class="active"' : '') !!}><a href="{{ route('qrs.external.index',		$result->id) }}">External Info</a></li>
				<li{!! ($result->tab == 'report'		? ' class="active"' : '') !!}><a href="{{ route('qrs.report.index',			$result->id) }}">Case Leader Report</a></li>
				<li{!! ($result->tab == 'review'		? ' class="active"' : '') !!}><a href="{{ route('qrs.review.index',			$result->id) }}">QA Review</a></li>
				<li{!! ($result->tab == 'response'		? ' class="active"' : '') !!}><a href="{{ route('qrs.response.index',		$result->id) }}">Final Response</a></li>
				<li{!! ($result->tab == 'timeline'		? ' class="active"' : '') !!}><a href="{{ route('qrs.timeline.index',		$result->id) }}">Timeline</a></li>
				<li{!! ($result->tab == 'verification'	? ' class="active"' : '') !!}><a href="{{ route('qrs.verification.index',	$result->id) }}">Verification</a></li>
				<li{!! ($result->tab == 'claims'		? ' class="active"' : '') !!}><a href="{{ route('qrs.claims.index',			$result->id) }}">Cost of Claims</a></li>
			@if ($result->IsAdmin())
				<li{!! ($result->tab == 'information'	? ' class="active"' : '') !!}><a href="{{ route('qrs.information.index',	$result->id) }}">QA Information</a></li>
				<li{!! ($result->tab == 'summary'		? ' class="active"' : '') !!}><a href="{{ route('qrs.summary.index',		$result->id) }}">Attachment Summary</a></li>
			@endif
			</ul>
		</div>
		<div class="col-md-10 tab-content-vertical">
			<div class="tab-pane active">
				@yield('details')
			</div>
		</div>
	</div>

@endsection