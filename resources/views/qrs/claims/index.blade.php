@extends('qrs.main.layout')

@section('glyphicon', 'glyphicon glyphicon-usd')
@section('header', 'Cost of claims')

@section('details')

	<link href="{{ asset('assets/css/bootstrap-sortable.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">

	<form method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<p>
		@if ($result->IsCanClaim())
			<a href="{{ route('qrs.claims.create', $result->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Add Claims</a>
			<a href="{{ route('qrs.claims.attachment', $result->id) }}" class="btn btn-success btn-sm" id="uploader"><span class="glyphicon glyphicon-file"></span> Add Attachment</a>
			<a href="{{ route('qrs.claims.notify', $result->id) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-envelope"></span> Send Notification</a>
			<a href="{{ route('qrs.claims.lock', $result->id) }}" class="btn btn-default btn-sm" onclick="return confirmAction('Are you sure?');"><span class="glyphicon glyphicon-lock"></span> Lock Claims</a>
			<button type="submit" id="submit" class="btn btn-danger btn-sm" style="display: none"><span class="glyphicon glyphicon-remove"></span> Delete</button>
		@endif
		@if ($result->lockclaim)
			<a href="{{ route('qrs.claims.unlock', $result->id) }}" class="btn btn-default btn-sm" onclick="return confirmAction('Are you sure?');">
				<span class="glyphicon glyphicon-briefcase"></span> Unlock
			</a>
		@endif
		</p>

		@if ($result->claims->count() > 0)
			<table class="table table-bordered table-striped table-hover sortable">
				<thead>
					<th>Claims Type</th>
					<th>Document Type</th>
					<th>Ref. No.</th>
					<th>Currency</th>
					<th class="amount">Ex. Rate</th>
					<th class="amount">Amount</th>
					<th class="amount">Amount (RM)</th>
					<th>Remarks</th>
				</thead>
				<tbody>
					@foreach ($result->claims as $claim)
					<tr>
						<td>
						@if ($result->IsCanClaim())
							<input type="checkbox" name="remove[]" class="remove" value="{{ $claim->id }}">
						@endif
							<a href="{{ route('qrs.claims.edit', [$claim->id, $result->id]) }}">{{ $claim->GetClaimsType() }}</a>
						</td>
						<td>{{ $claim->GetDocument() }}</td>
						<td>{{ $claim->refno }}</td>
						<td>{{ $claim->GetCurrency() }}</td>
						<td class="amount">{{ $claim->rate }}</td>
						<td class="amount">{{ $claim->amount }}</td>
						<td class="amount">{{ $claim->local }}</td>
						<td>{{ $claim->remarks }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr class="amount-total">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Total:</td>
						<td>{{ bcadd($result->claims->sum('amount'), 0, 3) }}</td>
						<td>{{ bcadd($result->claims->sum('local'), 0, 3) }}</td>
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>
		@else
			<div class="alert alert-danger" role="alert" align="center">No Claims</div>
		@endif

		@if ($result->IsCanClaim() || $result->commentc->count() > 0)
		<div class="row">
			<div class="col-md-12">
				<fieldset class="border">
					<legend class="border">Comment</legend>
					@if ($result->IsCanClaim())
					<div class="row">
						<div class="col-md-12">
							<div class="input-group">
								<input type="text" class="form-control input-sm" name="comment" id="comment" placeholder="enter your comment" />
								<span class="input-group-btn">
									<button type="submit" class="btn btn-info btn-sm">Send</button>
								</span>
							</div>
						</div>
					</div>
					@endif
					<div class="comment">
					@foreach ($result->commentc as $comment)
						<div class="row">
							<div class="col-md-12">
								<strong>{{ $comment->creator() }} ({{ $comment->created_at->format('d/m/Y h:i:s A') }}):</strong>
									{{ $comment->comment }}
							</div>
						</div>
					@endforeach
					</div>
				</fieldset>
			</div>
		</div>
		@endif
	</form>

	@if ($result->fileClaims->count() > 0)
	<div class="row">
		<div class="col-md-12">
			<fieldset class="border">
				<legend class="border">Attachment</legend>
				@foreach ($result->fileClaims as $file)
					{!! $file->getblock()  !!}
				@endforeach
			</fieldset>
		</div>
	</div>
	@endif

	<script src="{{ asset('assets/js/bootstrap-sortable.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.magnific.popup.min.js') }}"></script>
	<script>
		$(function(){
			$('#uploader').on('click', function(){
				Uploader($(this).attr('href'));
				return false;
			});

			$('.remove').on('change', function(){
				if ($('.remove:checked').length > 0){
					$('#submit').show();
				}else{
					$('#submit').hide();
				}
			});

			$('#comment').focus();

			$('#submit').on('click', function(){
				return confirmAction('Are you sure?');
			});

			Getlightbox();
		});
	</script>

@endsection