<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
	@if (is_null($nav))
		<p class="navbar-text navbar-right">
			Signed in as <a href="{{ route('switchlogin') }}">{{ $username }} <span class="glyphicon glyphicon-new-window"></span></a>
		</p>
	@else
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ route($nav['route']) }}">{{ $nav['label'] }}</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" >Menu <b class="caret"></b></a>
					{!! $nav['menu'] !!}
				</li>
			</ul>
			<p class="navbar-text navbar-right">
				Signed in as <a href="{{ route('switchlogin') }}" title="User ID: {{ auth()->user()->id }}">{{ $username }} <span class="glyphicon glyphicon-new-window"></span></a>
			</p>
			{!! $nav['search'] !!}
		</div>
	@endif
	</div>
</nav>