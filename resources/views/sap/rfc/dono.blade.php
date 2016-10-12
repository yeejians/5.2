@extends('layouts.default')

@section('title')
SAP RFC Get Delivery Number ::
@parent
@endsection

@section('content')

	<form id="form" class="form-horizontal" autocomplete="off" role="form">
		<div class="page-header">
			<h3><span class="glyphicon glyphicon-list-alt"></span> SAP RFC - Get Delivery Number</h3>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		</div>

		<div class="form-group {{ $errors->has('docno') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="docno">WB Ticket Number</label>
			<div class="col-md-2">
				<input type="text" class="form-control" name="docno" id="docno" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('dono') ? 'has-error' : '' }}" id="dono" style="display: none">
			<label class="col-md-2 control-label" for="dono">Delivery Number Updated</label>
			<div class="col-md-10">
				<p class="form-control-static" for="dono"></p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="button" class="btn btn-success" for="submit"><span class="glyphicon glyphicon-ok-sign"></span> Submit</button>
			</div>
		</div>
	</form>

	<script>
		$(function(){
			var
				$docno	= $('#docno'),
				$dono	= $('#dono'),
				$donop	= $('p[for="dono"]'),
				$btn	= $('button[for="submit"]');

			$btn.on('click', function(){
				if ($docno.val() == ''){
					return alert('Please enter WB Ticket Number');
				}

				$btn.attr('disabled', 'disabled').text('Loading...');

				$.get('{{ route('sap.rfc.getdono') }}?docno=' + $docno.val().toUpperCase(), function(data){
					$btn.removeAttr('disabled').text('Submit');
					$dono.show();
					$donop.text(data);
					$docno.val($docno.val().toUpperCase());
				}).fail(function(){
					$btn.removeAttr('disabled').text('Submit');
					$dono.hide();
					$donop.text('');
				});
			});
		});
	</script>

@endsection