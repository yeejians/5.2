<?php

namespace App\Http\Controllers\SAP;

use App\Http\Controllers\Controller;
use Cache;

class MainController extends Controller
{
	public function flushcache()
	{
		Cache::tags('sap')->flush();

		return 'OK';
	}
}