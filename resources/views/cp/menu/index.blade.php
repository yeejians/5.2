@extends('layouts.default')

@section('title')
Menu Setting ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">

	<div class="page-header">
		<h3>
			<span class="glyphicon glyphicon-book"></span>
			@if (isset($parent))
				<a href="{{ route('cp.menu.show', $parent->GetRoot()) }}">{{ $parent->GetRootLabel() }}</a>
				@if ($parent->parent_id)
					@foreach ($parent->root->sub as $sub)
						@if (in_array($sub->id, $nav))
							:: <a href="{{ route('cp.menu.show', $sub->id) }}">{{ $sub->label }}</a>
						@endif
					@endforeach
				@endif
			@else
				Root Menu
			@endif
		</h3>
	</div>

	<p>
		@if (empty($parent))
			<a href="{{ route('cp.menu.create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Create</a>
			<a href="{{ route('cp.menu.refresh') }}" class="btn btn-default"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
		@endif
	</p>

	@include('layouts.paginator', ['result' => $result])

	@if (isset($parent))
		<table class="table table-condensed table-striped table-horizontal">
			<tr>
				<th width="200px">Menu ID:</th>
				<td>{{ $parent->id }}</td>
			</tr>
			<tr>
				<th>Menu Name:</th>
				<td>{{ $parent->label }}</td>
			</tr>
			<tr>
				<th>Route Name:</th>
				<td>{{ $parent->route }}</td>
			</tr>
			<tr>
				<th>Menu Sequence:</th>
				<td>{{ $parent->sequence }}</td>
			</tr>
			@if ($parent->parent_id)
			<tr>
				<th>Parent Name:</th>
				<td>{{ $parent->parent->label }}</td>
			</tr>
			@endif
			<tr>
				<th>Everyone can view:</th>
				<td>{{ $parent->GetPublic() }}</td>
			</tr>
			<tr>
				<th>Hide from navigation:</th>
				<td>{{ $parent->GetHide() }}</td>
			</tr>
			<tr>
				<th>Have search field:</th>
				<td>{{ $parent->GetSearch() }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<a href="{{ route('cp.menu.create.sub', $parent->id) }}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span> Create</a>
					<a href="{{ route('cp.menu.edit', $parent->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
					<a href="{{ route('cp.menu.assign', $parent->id) }}" class="btn btn-assign btn-sm"><span class="glyphicon glyphicon-user"></span> Assign</a>
					<a href="{{ route('cp.menu.tree', $parent->id) }}" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-tree-deciduous"></span> Tree View</a>
					@if ($result->count() == 0)
						<a href="{{ route('cp.menu.delete', $parent->id) }}" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Delete</a>
					@endif
				</td>
			</tr>
			@if ($parent->users->count() > 0)
			<tr>
				<th>Assigned Users:</th>
				<td>
					@foreach ($parent->users as $user)
						{{ $user->display_name }}<br />
					@endforeach
				</td>
			</tr>
			@endif
			@if ($parent->groups->count() > 0)
			<tr>
				<th>Assigned Groups:</th>
				<td>
					@foreach ($parent->groups as $group)
						{{ $group->name }}<br />
					@endforeach
				</td>
			</tr>
			@endif
		</table>
	@endif

	<div class="page-header"><h3>Sub Menu</h3></div>

	<table id="sequence" class="table table-bordered table-striped table-hover sortable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Menu Name</th>
				<th>Menu Route</th>
				<th>Menu Sequence</th>
				<th>Have Search</th>
				<th>Is Hide</th>
				<th>Is Public</th>
				<th># of Sub Menu</th>
				<th># of Users</th>
				<th># of Groups</th>
				<th width="60px">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@if ($result->count() > 0)
				@foreach ($result as $key)
				<tr>
					<td>{{ $key->id }}</td>
					<td>{{ $key->label }}</td>
					<td>{{ $key->route }}</td>
					<td>{{ $key->sequence }}</td>
					<td>{{ $key->GetSearch() }}</td>
					<td>{{ $key->GetHide() }}</td>
					<td>{{ $key->GetPublic() }}</td>
					<td>{{ $key->child->count() }}</td>
					<td>{{ $key->users->count() }}</td>
					<td>{{ $key->groups->count() }}</td>
					<td><a href="{{ route('cp.menu.show', $key->id) }}" class="btn btn-primary btn-xs">Details</a></td>
				</tr>
				@endforeach
			@else
			<tr>
				<td colspan="11">No results</td>
			</tr>
			@endif
		</tbody>
	</table>

	@include('layouts.paginator', ['result' => $result])

	<script src="{{ asset('assets/js/bootstrap-editable.min.js') }}"></script>

@endsection