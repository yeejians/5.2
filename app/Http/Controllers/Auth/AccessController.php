<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CP\Person;
use Libraries\Helper;
use Auth;

class AccessController extends Controller
{
	public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'switchlogin']]);
    }

	public function login()
	{
		$redirect	= session()->get('url.intended', '/');
		$logon		= Helper::GetLogonInfo();

		if (!is_null($user = Person::where('username', $logon['username'])->first()))
		{
			Auth::login($user);
			Helper::SetLoginRecord($redirect, $user, $logon);

			return redirect()->intended('/');
		}

		$import		= true;
		$username	= $logon['username'];

		return view('home.sync', compact('import', 'username', 'redirect'));
	}

	public function logout()
	{
		Auth::logout();

		return redirect(config('app.insight'));
	}

	public function switchlogin()
	{
		$user = auth()->user()->username;
		$auth = Helper::GetLogonInfo();

		if ($user == $auth['username'])
		{
			return response('', 401, ['WWW-Authenticate: Negotiate']);
		}

		Auth::logout();
		
		return redirect()->route('login');
	}
}