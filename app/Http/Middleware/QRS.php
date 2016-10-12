<?php

namespace App\Http\Middleware;

use App\Models\QRS\Complaint;
use Closure;

class QRS
{
	public function handle($request, Closure $next, $guard = null)
	{
		$id	= last($request->segments());

		if ($result	= Complaint::find($id))
		{
			if ($result->CanView())
			{
				return $next($request);
			}

			abort(403);
		}

		abort(404);
	}
}