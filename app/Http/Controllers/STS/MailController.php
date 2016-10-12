<?php

namespace App\Http\Controllers\STS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\STS\Report;
use App\Models\CP\Person;

class MailController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
		$this->middleware('access');
    }

	public function index()
	{
		$result = Report::all();

		return view('sts.mail.index', compact('result'));
	}

	public function show($id)
	{
		if ($result = Report::find($id))
		{
			return view('sts.mail.show', compact('result'));
		}

		abort(404);
	}

	public function setting($id = null)
	{
		if ($result = Report::find($id))
		{
			return view('sts.mail.setting', compact('result'));
		}

		abort(404);
	}

	public function settingPost(Request $request, $id = null)
	{
		$this->validate($request, [
			'subject'	=> 'required',
			'message'	=> 'required',
		]);

		$model			= Report::find($id);
		$model->subject	= $request->input('subject');
		$model->message	= $request->input('message');
		$model->autosend= $request->input('autosend', 0);
		$model->format	= $request->input('format', 'pdf');
		$model->save();

		return redirect()->route('sts.mail.show', $model->id);
	}

	public function recipient($type = '', $id = null)
	{
		if ($result = Report::find($id) and in_array($type, ['to', 'cc']))
		{
			$lists		= $type == 'to' ? $result->to() : $result->cc();
			$recipient	= $type == 'to' ? $result->to : $result->cc;
			$external	= $type == 'to' ? $result->exto : $result->excc;
			$users		= Person::active()->whereNotIn('id', $lists->lists('user_id'))->get();

			return view('sts.mail.recipient', compact('result', 'users', 'recipient', 'external'));
		}

		abort(404);
	}

	public function recipientPost(Request $request, $type = '', $id = null)
	{
		$result		= Report::find($id);
		$recipient	= $type == 'to' ? $result->to() : $result->cc();
		$external	= $type == 'to' ? $result->exto() : $result->excc();
		$add		= $request->input('add');
		$remove		= $request->input('remove');
		$destroy	= $request->input('destroy');
		$email		= $request->input('email');
		$name		= $request->input('name');

		if ($email[1])
		{
			for ($i = 1; $i <= count($email); $i++)
			{
				$external->create([
					'email' => $email[$i],
					'name' => $name[$i],
				]);
			}		
		}

		if (is_array($destroy))
		{
			$external->whereIn('id', $destroy)->delete();
		}

		if (is_array($add))
		{
			foreach ($add as $addUser)
			{
				$recipient->attach($addUser);
			}
		}

		if (is_array($remove))
		{
			foreach ($remove as $removeUser)
			{
				$recipient->detach($removeUser);
			}
		}

		return redirect()->route('sts.mail.show', $result->id);
	}
}