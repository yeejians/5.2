$(function()
{
	$('input').placeholder();
});

function confirmAction(showMessage)
{
	var confirmed = confirm(showMessage);

	return confirmed;
}

function switchDateFormat(obj){
	obj.val(obj.val().replace(/[-]/g, '/'));
}

function changeDateFormat(obj){
	obj.val(obj.val().replace(/[/]/g, '-'));
}

function Uploader(url){
	window.open(url, 'uploader', 'width=500, height=500, location=no, menubar=no, scrollbars=no, status=no, toolbar=no');
}

function RefreshParent(){
	if (window.opener != null && !window.opener.closed){
		window.opener.location.reload();
	}
}

function Getlightbox()
{
	$('.attachment').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		image: {
			verticalFit: true,
			titleSrc: function(item){
				return '<a href="'+item.el.attr('data-source')+'" style="color: white;">Download '+item.el.attr('title')+'</a>';
			}
		}
	});
}

function checkRfc(url, input, output){

	var
		$input	= $('#'+input),
		$output	= $('#'+output),
		$button	= $('button[for="'+input+'"]');

	if($input.val() == ''){
		return alert('Please enter value');
	}

	var str = $input.val().replace(/\s+/g, '');

	$input.val(str.toUpperCase());

	$button
		.attr('disabled', 'disabled')
		.text('Loading...');

	$.get(url + '?id=' + $input.val(), function(data){
		$button
			.removeAttr('disabled')
			.text('Check');
		$output.val(data);
	}).fail(function(){
		$button
			.removeAttr('disabled')
			.text('Check');
		$output.val('');
	});
}

if (navigator.userAgent.match(/IEMobile\/10\.0/))
{
	var msViewportStyle = document.createElement('style');
	msViewportStyle.appendChild(document.createTextNode('@-ms-viewport{width:auto!important}'));
	document.getElementsByTagName('head')[0].appendChild(msViewportStyle);
}
