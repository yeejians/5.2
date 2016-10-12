<?php

namespace App\Http\Controllers\TP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;

use App\Models\CP\Person;
use App\Models\CP\Group;

class MainController extends Controller
{
	protected $GroupID = 1;	//-- TP.Admin;

	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
		$this->middleware('access');
    }

	public function index()
	{
		return view('tp.main.index');
	}

	public function flushcache()
	{
		Cache::tags('tp')->flush();

		return redirect()->route('tp.index');
	}

	public function admin()
	{
		$result = Group::find($this->GroupID);
		$lists	= $result->users()->lists('users.id')->toArray();
		$users	= Person::active()->whereNotIn('id', $lists)->get();

		return view('tp.main.admin', compact('result', 'users'));
	}

	public function adminPost(Request $request)
	{
		$result	= Group::find($this->GroupID);
		$add	= $request->input('add');
		$remove	= $request->input('remove');

		if (is_array($add))
		{
			foreach ($add as $addUser)
			{
				$result->users()->attach($addUser);
			}
		}

		if (is_array($remove))
		{
			$result->users()->detach($remove);
		}

		return redirect()->route('tp.admin');
	}
}