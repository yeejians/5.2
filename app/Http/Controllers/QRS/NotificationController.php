<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use App\Models\QRS\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
		$this->middleware('access');
    }

	public function index()
	{
		$result = Notification::all();

		return view('qrs.notification.index', compact('result'));
	}

	public function create()
	{
		return view('qrs.notification.create');
	}

	public function createPost(Request $request)
	{
		$this->validate($request, [
			'prefixkey'	=> 'required',
			'name'		=> 'required',
			'subject'	=> 'required',
			'message'	=> 'required',
		]);

		$model				= new Notification;
		$model->prefixkey	= $request->input('prefixkey');
		$model->name		= $request->input('name');
		$model->subject		= $request->input('subject');
		$model->message		= $request->input('message');
		$model->save();

		return redirect()->route('qrs.notification.index');
	}

	public function edit($id)
	{
		if ($result = Notification::find($id))
		{
			return view('qrs.notification.edit', compact('result'));
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'prefixkey'	=> 'required',
			'name'		=> 'required',
			'subject'	=> 'required',
			'message'	=> 'required',
		]);

		$model				= Notification::find($id);
		$model->prefixkey	= $request->input('prefixkey');
		$model->name		= $request->input('name');
		$model->subject		= $request->input('subject');
		$model->message		= $request->input('message');
		$model->save();

		return redirect()->route('qrs.notification.show', $model->id);
	}

	public function show($id)
	{
		if ($result = Notification::find($id))
		{
			return view('qrs.notification.show', compact('result'));
		}

		abort(404);
	}

	public function delete($id)
	{
		if ($result = Notification::find($id))
		{
			$result->delete();

			return redirect()->route('qrs.notification.index');
		}

		abort(404);
	}
}