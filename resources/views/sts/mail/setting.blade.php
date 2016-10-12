@extends('layouts.default')

@section('title')
Mail Setting :: Content ::
@parent
@endsection

@section('content')

	<div class="page-header"><h3><span class="glyphicon glyphicon-list-alt"></span> {{ $result->title }} :: Setting</h3></div>

	<form id="reportform" class="form-horizontal" method="post" action="" autocomplete="off" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="subject">Subject</label>
			<div class="col-md-10">
				<input type="text" class="form-control" name="subject" id="subject" value="{{ old('subject', $result->subject) }}" />
			</div>
		</div>

		<div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="message">Message</label>
			<div class="col-md-10">
				<textarea class="ckeditor" name="message" id="message" rows="5">
					{{ old('message', $result->message) }}
				</textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="available">&nbsp</label>
			<div class="col-md-10">
				<div class="well">
					<strong>Available variable:</strong>
					<ul>
						<li><strong>@Date@</strong> - Date</li>
						<li><strong>@Pending@</strong> - Total Document Pending</li>
						<li><strong>@Overdue@</strong> - Total Document Overdue</li>
						<li><strong>@AvgOverdue@</strong> - Average Document Overdue</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="form-group {{ $errors->has('autosend') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="autosend">Auto Send Mail</label>
			<div class="col-md-2">
				<select class="form-control" name="autosend" id="autosend">
					<option value="1"{{ ($result->autosend == 1 ? ' selected="selected"' : '') }}>Enable</option>
					<option value="0"{{ ($result->autosend == 0 ? ' selected="selected"' : '') }}>Disable</option>
				</select>
			</div>
		</div>

		<div class="form-group {{ $errors->has('format') ? 'has-error' : '' }}">
			<label class="col-md-2 control-label" for="format">Output Format</label>
			<div class="col-md-2">
				<select class="form-control" name="format" id="format">
					<option value="pdf"{{ ($result->format == 'pdf' ? ' selected="selected"' : '') }}>PDF</option>
					<option value="xls"{{ ($result->format == 'xls' ? ' selected="selected"' : '') }}>Excel</option>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Confirm</button>
				<a href="{{ route('sts.mail.show', $result->id) }}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
			</div>
		</div>
	</form>

	<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>

@endsection