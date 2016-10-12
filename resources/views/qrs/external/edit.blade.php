@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-duplicate')
@section('header', 'External Info')

@section('details')

	<link href="{{ asset('assets/css/redmond/jquery.ui.min.css') }}" rel="stylesheet">

	<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('external_info') ? 'has-error' : '' }}">
			<label class="col-md-2 col-xs-fixed control-label" for="external_info">External Info:</label>
			<div class="col-md-9">
				<label class="radio-inline"><input type="radio" name="external_info" id="external_info_1" value="1"{!! (old('external_info', $result->external_info) == 1 ? ' checked="checked"' : '') !!} /> Need</label>
				<label class="radio-inline"><input type="radio" name="external_info" id="external_info_0" value="0"{!! (old('external_info', $result->external_info) == 0 ? ' checked="checked"' : '') !!} /> No need</label>
			</div>
		</div>

		<div id="external" style="display: none">
			<div class="form-group {{ $errors->has('external_at') ? 'has-error' : '' }}">
				<label class="col-md-2 col-xs-fixed control-label" for="external_at">Submit Date:</label>
				<div class="col-md-2">
					<input type="text" class="form-control" name="external_at" id="external_at" value="{{ old('external_at', $result->GetExternalInfoSubmitDate()) }}" style="position: relative; z-index: 3;" />
				</div>
			</div>

			<div class="form-group {{ $errors->has('external_remark') ? 'has-error' : '' }}">
				<label class="col-md-2 col-xs-fixed control-label" for="external_remark">Remarks:</label>
				<div class="col-md-8">
					<textarea class="ckeditor" name="external_remark" id="external_remark">
						{{ old('external_remark', $result->external_remark) }}
					</textarea>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 col-xs-fixed control-label">&nbsp;</label>
			<div class="col-md-10">
				<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('qrs.external.index', $result->id) }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/jquery.ui.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.ui.config.js') }}"></script>
	<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
	<script>
		$(function(){
			if ($('#external_info_1:checked').length > 0){
				$('#external').show();
			}

			$('#external_at').datepicker({
				defaultDate: '-1m',
				dateFormat: 'dd/mm/yy',
				numberOfMonths: 3
			});

			$('#external_info_1').on('click', function(){
				$('#external').show();
			});

			$('#external_info_0').on('click', function(){
				$('#external').hide();
				$('#external_at').val('');
				$('#external_remark').val('');
			});
		});
	</script>

@endsection