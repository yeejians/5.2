<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\CP\Menu;
use Cache;
use Route;

class MainController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('access');
    }

	public function index()
	{
		$route	= Route::currentRouteName();
		$result	= Menu::where('route', $route)->first();

		return view('cp.main.index', compact('result'));
	}

	public function flushcache()
	{
		Cache::tags('cp')->flush();

		return redirect()->route('cp.index');
	}
}