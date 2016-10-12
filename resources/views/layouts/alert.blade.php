<div class="page-header"></div>
@if (count($errors) > 0)
<div class="space">
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4>Error</h4>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
</div>
@endif

@if (session('success'))
<div class="space">
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4>Success</h4>
		{{ session('success') }}
	</div>
</div>
@endif

@if (session('error'))
<div class="space">
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4>Error</h4>
		{{ session('error') }}
	</div>
</div>
@endif

@if (session('warning'))
<div class="space">
	<div class="alert alert-warning alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4>Warning</h4>
		{{ session('warning') }}
	</div>
</div>
@endif

@if (session('info'))
<div class="space">
	<div class="alert alert-info alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4>Info</h4>
		{{ session('info') }}
	</div>
</div>
@endif