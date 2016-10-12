<?php

namespace Libraries;

use App\Models\CP\Menu;
use Illuminate\View\View;
use Libraries\Builder;
use Libraries\Helper;
use Route;
use Cache;
use Auth;

class MenuComposer
{
	public function compose(View $view)
	{
		$route		= Route::currentRouteName();
		$request	= request()->segment(1);
		$username	= 'guest';

		if (Auth::check())
		{
			$username	= auth()->user()->username;

			if ($nav = Cache::tags([$request, $username])->get('nav'))
			{
				return $view->with(['nav' => $nav, 'username' => $username]);
			}

			if ($result	= Menu::where('route', $route)->first())
			{
				$root			= Menu::find($result->GetRoot());
				$lists			= $result->root_id ? Helper::GetUserMenu($root) : Helper::GetUserMenu($result);
				$menu			= $result->root_id ? Builder::GetMenu($root, $lists) : Builder::GetMenu($result, $lists);
				$nav['route']	= $result->root_id ? $result->root->route : $result->route;
				$nav['label']	= $result->root_id ? $result->root->label : $result->label;
				$nav['search']	= $result->GetSearchMenu();
				$nav['menu']	= $menu ? '<ul class="dropdown-menu">'.$menu.'</ul>' : '';

				Cache::tags([$request, $username])->forever('nav', $nav);

				return $view->with(['nav' => $nav, 'username' => auth()->user()->username]);
			}

			return $view->with(['nav' => null, 'username' => auth()->user()->username]);
		}

		return $view->with(['nav' => null, 'username' => $username]);
	}
}