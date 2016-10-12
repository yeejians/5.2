<?php

namespace App\Http\Middleware;

use App\Models\CP\Menu;
use Libraries\Helper;
use Closure;
use Route;

class Accessibility
{
	public function handle($request, Closure $next, $guard = null)
	{
		$route	= Route::currentRouteName();
		$menu	= Menu::where('route', $route)->first();

		if (is_null($menu))
		{
			return $next($request);
		}

		if ($menu->super())
		{
			return $next($request);
		}

		$map	= Helper::GetMap($menu);
		$block	= Helper::GetBlockMenu($map);
		$allow	= Helper::GetAllowMenu($map);
		$lists	= array_diff($block, $allow);

		if (count($lists) == 0)
		{
			return $next($request);
		}

		abort(403);
	}
}