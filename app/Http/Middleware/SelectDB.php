<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class SelectDB
{
	public function handle($request, Closure $next, $guard = null)
	{
		$db = config('database.connections');
		$id = $request->segment(1);

		if (array_key_exists($id, $db))
		{
			DB::setDefaultConnection($id);
		}
		else
		{
			DB::setDefaultConnection(config('database.default'));
		}

		return $next($request);
	}
}