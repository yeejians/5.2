@extends('layouts.default')

@section('title')
Mail Setting :: Recipient ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/select2.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/select2-bootstrap.css') }}" rel="stylesheet">
	<style>
	.manual {
		padding-left: 6px;
	}

	.manual div {
		margin-right: 5px;
	}
	</style>

	<div class="page-header"><h3><span class="glyphicon glyphicon-list-alt"></span> {{ $result->title }} :: Recipient :: {{ strtoupper(request()->segment(4)) }}</h3></div>

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form" id="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="row">
			<div class="form-group">
				<label class="col-md-2 control-label" for="add">Select User:</label>
				<div class="col-md-10">
					<select class="form-control populate" multiple name="add[]" id="add">
						@foreach ($users as $add)
							<option value="{{ $add->id }}">{{ $add->display_name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>

		@if ($recipient->count() > 0)
		<div class="row">
			<div class="form-group">
				<label class="col-md-2 control-label" for="remove">Current User:<br /><span class="label label-danger">* tick to remove from list</span></label>
				<div class="col-md-10">
					@foreach ($recipient as $remove)
						<div class="checkbox"><input type="checkbox" name="remove[]" value="{{ $remove->id }}"> {{ $remove->display_name }}</div>
					@endforeach
				</div>
			</div>
		</div>
		@endif

		<div class="page-header"></div>

		<div class="row manual" id="div_manual_1">
			<label class="col-md-2 control-label">&nbsp;</label>
			<div class="col-md-4">
				<div class="form-group">
					<label for="email_1">Manual Input Email Address</label>
					<div class="input-group">
						<span class="input-group-btn"><a href="#" class="btn btn-primary add-txt" data-id="1"><span class="glyphicon glyphicon-plus-sign"></span></a></span>
						<input type="text" class="form-control" name="email[1]" id="email_1" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="name_1">Name (Salutation)</label>
					<input type="text" class="form-control" name="name[1]" id="name_1" />
				</div>
			</div>
		</div>

		@if ($external->count() > 0)
		<div class="row">
			<div class="form-group">
				<label class="col-md-2 control-label" for="destroy">Current External Email:<br /><span class="label label-danger">* tick to remove from list</span></label>
				<div class="col-md-10">
					@foreach ($external as $destroy)
						<div class="checkbox"><input type="checkbox" name="destroy[]" value="{{ $destroy->id }}"> {{ $destroy->name }} &lt;{{ $destroy->email }}&gt;</div>
					@endforeach
				</div>
			</div>
		</div>
		@endif

		<div class="row">
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
					<a href="{{ route('sts.mail.show', $result->id) }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
				</div>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.validate.config.js') }}"></script>
	<script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
	<script>
		$(function(){
			$('#add').select2();

			$('.form-horizontal').on('click', '.add-txt', function(){
				var
					counter		= $('.manual').length + 1,
					div_manual	= $('<div class="row manual" id="div_manual_'+counter+'"><label class="col-md-2 control-label">&nbsp;</label><div class="col-md-4"><div class="form-group"><div class="input-group">'+
									'<span class="input-group-btn"><a href="#" class="btn btn-danger remove-txt" data-id="'+counter+'"><span class="glyphicon glyphicon-remove-sign"></span></a></span>'+
									'<input type="text" class="form-control" name="email['+counter+']" id="email_'+counter+'" /></div></div></div>'+
									'<div class="col-md-4"><div class="form-group"><input type="text" class="form-control" name="name['+counter+']" id="name_'+counter+'" /></div></div></div>');

				div_manual.hide();
				$('#div_manual_1').after(div_manual);
				div_manual.fadeIn('slow');

				$('#email_'+counter).rules('add', {email: true});
				$('#name_'+counter).rules('add', {required: '#email_'+counter+':filled'});

				return false;
			});

			$('.form-horizontal').on('click', '.remove-txt', function(){
				var id = $(this).data('id');

				$('#div_manual_'+id).fadeOut('fast', function(){$(this).remove();});

				return false;
			});

			$('#form').validate({
				ignore: '',
				rules: {
					'email[1]': {
						email: true
					},
					'name[1]': {
						required: '#email_1:filled'
					}
				}
			});
		});
	</script>

@endsection