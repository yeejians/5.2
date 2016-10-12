function checkRoute(routeURL, routeName)
{
	if(routeName.length <= 0)
	{
		alert('Please enter route');

		return false;
	}

	var Response = $.ajax({
		url: routeURL + '?route=' + routeName,
		type: 'get',
		async: false
	}).responseText;

	if(Response != 'SUCCESS')
	{
		alert(Response);

		return false;
	}

	return true;
}

function SyncAD(route, redirect)
{
	var
		$message	= $('#message'),
		$img		= $('img'),
		$jumbotron	= $('.jumbotron');

	setTimeout(function()
	{
		var Response = $.ajax({
			url: route,
			type: 'get',
			async: false
		}).responseText;

		if(Response == 'SUCCESS')
		{
			$message.text('User data synchronized, redirecting...');

			setTimeout(function(){window.location = (redirect);}, 1000);
		}
		else if(Response == 'DEACTIVATED')
		{
			$message.text('User has been disabled in Active Directory, deactivating...');

			setTimeout(function(){window.location = (redirect);}, 1000);
		}
		else if(Response == 'DELETED')
		{
			$message.text('User has been deleted from Active Directory, deactivating...');

			setTimeout(function(){window.location = (redirect);}, 1000);
		}
		else
		{
			$message.remove(); 
			$img.remove(); 
			$jumbotron.append('<div class="alert alert-danger"><strong>Whoops! Something\'s went wrong,<br /> Please contact Helpdesk.MY.LC@croklaan.com<br /><br />Error Response: </strong>'+Response+'</div>');
			$jumbotron.append('<a href="' + redirect + '" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>');
		}
	}, 2000);
}