<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\QRS\Master;

class MasterController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
		$this->middleware('access');
    }

	public function index()
	{
		$section = request()->segment(3);

		if ($result = Master::where('section', $section)->paginate())
		{
			return view('qrs.'.$section.'.index', compact('result'));
		}
		
		abort(404);
	}

	public function create()
	{
		$section = request()->segment(3);

		return view('qrs.'.$section.'.create');
	}

	public function createPost(Request $request)
	{
		$this->validate($request, [
			'name'		=> 'required',
		]);

		$section		= request()->segment(3);

		$model			= new Master;
		$model->name	= $request->input('name');
		$model->section	= $section;
		$model->save();

		return redirect()->route('qrs.'.$section.'.index');
	}

	public function edit($id = null)
	{
		if ($result = Master::find($id))
		{
			$section = request()->segment(3);

			return view('qrs.'.$section.'.edit', compact('result'));
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'name'		=> 'required',
		]);

		$section		= request()->segment(3);

		$model			= Master::find($id);
		$model->name	= $request->input('name');
		$model->save();

		return redirect()->route('qrs.'.$section.'.show', $model->id);
	}

	public function show($id = null)
	{
		if ($result = Master::find($id))
		{
			$section = request()->segment(3);

			return view('qrs.'.$section.'.show', compact('result'));
		}

		abort(404);
	}

	public function delete($id)
	{
		if ($result = Master::find($id))
		{
			$section = request()->segment(3);

			$result->delete();

			return redirect()->route('qrs.'.$section.'.index');
		}

		abort(404);
	}
}