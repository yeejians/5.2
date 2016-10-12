<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CP\Site;

class SiteController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
		$this->middleware('access');
    }

	public function index()
	{
		$result = Site::all();

		return view('cp.site.index', compact('result'));
	}

	public function create()
	{
		return view('cp.site.create');
	}

	public function createPost(Request $request)
	{
		$this->validate($request, [
			'name'		=> 'required|unique:sites',
			'shortname'	=> 'required|max:20',
			'sapcode'	=> 'required|integer',
		]);

		$model				= new Site;
		$model->name		= $request->input('name');
		$model->shortname	= $request->input('shortname');
		$model->sapcode		= $request->input('sapcode');
		$model->save();

		return redirect()->route('cp.site.index');
	}

	public function edit($id = null)
	{
		if ($result = Site::find($id))
		{
			return view('cp.site.edit', compact('result'));
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'name'		=> 'required|unique:sites,name,'.$id,
			'shortname'	=> 'required|max:20',
			'sapcode'	=> 'required|integer',
		]);

		$model				= Site::find($id);
		$model->name		= $request->input('name');
		$model->shortname	= $request->input('shortname');
		$model->sapcode		= $request->input('sapcode');
		$model->save();

		return redirect()->route('cp.site.index');
	}

	public function show($id)
	{
		if ($result = Site::find($id))
		{
			return view('cp.site.show', compact('result'));
		}

		abort(404);
	}

	public function delete($id)
	{
		if ($result = Site::find($id))
		{
			$result->delete();

			return redirect()->route('cp.site.index');
		}

		abort(404);
	}
}