<?php

namespace App\Http\Controllers\SAP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Libraries\Helper;

class SonoController extends Controller
{
	public function getdono(Request $request)
	{
		if ($request->ajax())
		{
			$sono	= $request->input('sono');

			if ($sono)
			{

			}

			return response('DATA NOT FOUND', 404);
		}

		abort(403);
	}
}