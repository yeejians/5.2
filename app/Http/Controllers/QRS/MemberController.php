<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;

use App\Models\QRS\Member;
use App\Models\QRS\Person;

class MemberController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
		$this->middleware('access');
    }

	public function caseleader()
	{
		$result	= Member::where('name', 'QR.Caseleader')->first();
		$keys	= $result->user()->lists('users.id');
		$lists	= $keys ? Person::user()->whereNotIn('id', $keys)->get() : Person::user()->get();

		return view('qrs.member.caseleader', compact('result', 'lists'));
	}

	public function caseleaderPost(Request $request)
	{
		$add	= $request->input('add');
		$remove	= $request->input('remove');
		$result	= Member::where('name', 'QR.Caseleader')->first();

		if (is_array($add))
		{
			$result->user()->attach($add);
		}

		if (is_array($remove))
		{
			$result->user()->detach($remove);
		}

		return redirect()->route('qrs.member.caseleader');
	}

	public function defaultcc()
	{
		$result	= Member::where('name', 'QR.DefaultCc')->first();
		$keys	= $result->user()->lists('users.id');
		$lists	= $keys ? Person::user()->whereNotIn('id', $keys)->get() : Person::user()->get();

		return view('qrs.member.defaultcc', compact('result', 'lists'));
	}

	public function defaultccPost(Request $request)
	{
		$add	= $request->input('add');
		$remove	= $request->input('remove');
		$result	= Member::where('name', 'QR.DefaultCc')->first();

		if (is_array($add))
		{
			$result->user()->attach($add);
		}

		if (is_array($remove))
		{
			$result->user()->detach($remove);
		}

		return redirect()->route('qrs.member.defaultcc');
	}

	public function defaultqa()
	{
		$result	= Member::where('name', 'QR.DefaultQA')->first();
		$keys	= $result->user()->lists('users.id');
		$lists	= $keys ? Person::user()->whereNotIn('id', $keys)->get() : Person::user()->get();

		return view('qrs.member.defaultqa', compact('result', 'lists'));
	}

	public function defaultqaPost(Request $request)
	{
		$add	= $request->input('add');
		$remove	= $request->input('remove');
		$result	= Member::where('name', 'QR.DefaultQA')->first();

		if (is_array($add))
		{
			$result->user()->attach($add);
		}

		if (is_array($remove))
		{
			$result->user()->detach($remove);
		}

		return redirect()->route('qrs.member.defaultqa');
	}

	public function claims()
	{
		$result	= Member::where('name', 'QR.Claims')->first();
		$keys	= $result->user()->lists('users.id');
		$lists	= $keys ? Person::user()->whereNotIn('id', $keys)->get() : Person::user()->get();

		return view('qrs.member.claims', compact('result', 'lists'));
	}

	public function claimsPost(Request $request)
	{
		$add	= $request->input('add');
		$remove	= $request->input('remove');
		$result	= Member::where('name', 'QR.Claims')->first();

		if (is_array($add))
		{
			$result->user()->attach($add);
		}

		if (is_array($remove))
		{
			$result->user()->detach($remove);
		}

		$this->flushcache();

		return redirect()->route('qrs.member.claims');
	}

	private function flushcache()
	{
		Cache::tags('qrs')->flush();
	}
}