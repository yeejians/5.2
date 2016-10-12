@extends('layouts.default')

@section('title')
Attachment Uploader :: {{ $data['refno'] }} ::
@parent
@endsection

@section('content')

	<link href="{{ asset('assets/css/uploadifive.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/uploadify.css') }}" rel="stylesheet">

	<div class="page-header"><h3><span class="glyphicon glyphicon-open"></span> Attachment Uploader :: {{ $data['refno'] }}</h3></div>

	<form><input id="upload" name="upload" type="file" multiple="true" /></form>

	<script src="{{ asset('assets/js/jquery.uploadifive.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.uploadify.min.js') }}"></script>
	<script>
		$(function(){
			$(window).on('beforeunload', function(){
				RefreshParent();
			});

			if(window.FormData === undefined)
			{
				$('#upload').uploadify({
					'formData'	: {'_token' : '{{ csrf_token() }}'},
					'swf'		: '{{ asset('assets/css/uploadify.swf') }}',
					'uploader'	: '{{ $data['uploader'] }}',
					'onError'	: function(errorType){alert(errorType);}
				});
			}
			else
			{
				$('#upload').uploadifive({
					'auto'			: true,
					'formData'		: {'_token' : '{{ csrf_token() }}'},
					'uploadScript'	: '{{ $data['uploader'] }}',
					'onError'		: function(errorType){alert(errorType);}
				});
			}
		});
	</script>

@endsection