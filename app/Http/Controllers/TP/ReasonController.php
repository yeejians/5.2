<?php

namespace App\Http\Controllers\TP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TP\Reason;

class ReasonController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
		$this->middleware('access');
    }

	public function index()
	{
		$result = Reason::all();

		return view('tp.reason.index', compact('result'));
	}

	public function create()
	{
		return view('tp.reason.create');
	}

	public function createPost(Request $request)
	{
		$this->validate($request, [
			'name'		=> 'required',
		]);

		$model				= new Reason;
		$model->name		= $request->input('name');
		$model->save();

		return redirect()->route('tp.reason.show');
	}

	public function edit($id = null)
	{
		if ($result = Reason::find($id))
		{
			return view('tp.reason.edit', compact('result'));
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'name'		=> 'required',
		]);

		$model				= Reason::find($id);
		$model->name		= $request->input('name');
		$model->save();

		return redirect()->route('tp.reason.show', $model->id);
	}

	public function show($id = null)
	{
		if ($result = Reason::find($id))
		{
			return view('tp.reason.show', compact('result'));
		}

		abort(404);
	}

	public function delete($id)
	{
		if ($result = Reason::find($id))
		{
			$result->delete();

			return redirect()->route('tp.reason.index');
		}

		abort(404);
	}
}