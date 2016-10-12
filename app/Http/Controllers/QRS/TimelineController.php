<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\QRS\Complaint;

class TimelineController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
    }

	public function index($id)
	{
		if ($result	= Complaint::find($id))
		{
			if ($result->CanView())
			{
				$result->tab = 'timeline';

				return view('qrs.timeline.index', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}
}