<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CP\Person;
use App\Models\CP\Group;

class GroupController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('access');
    }

	public function index()
	{
		$result = Group::all();

		return view('cp.group.index', compact('result'));
	}

	public function create()
	{
		return view('cp.group.create');
	}

	public function createPost(Request $request)
	{
		$this->validate($request, [
			'name'		=> 'required|unique:groups',
		]);

		$model			= new Group;
		$model->name	= $request->input('name');
		$model->save();

		return redirect()->route('cp.group.index');
	}

	public function edit($id = null)
	{
		if ($result = Group::find($id))
		{
			return view('cp.group.edit', compact('result'));
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'name'		=> 'required|unique:groups,name,'.$id,
		]);

		$model			= Group::find($id);
		$model->name	= $request->input('name');
		$model->save();

		return redirect()->route('cp.group.show', $model->id);
	}

	public function show($id = null)
	{
		if ($result = Group::find($id))
		{
			return view('cp.group.show', compact('result'));
		}

		abort(404);
	}

	public function delete($id)
	{
		if ($result = Group::find($id))
		{
			if ($result->users->count() == 0)
			{
				$result->delete();

				return redirect()->route('cp.group.index');
			}
			else
			{
				return back()->with('error', 'Group have users, cannot delete');
			}
		}

		abort(404);
	}

	public function assign($id = null)
	{
		if ($result = Group::find($id))
		{
			$users	= Person::active()->whereNotIn('id', $result->users()->lists('user_id'))->get();

			return view('cp.group.assign', compact('result', 'users'));
		}

		abort(404);
	}

	public function assignPost(Request $request, $id = null)
	{
		$result		= Group::find($id);
		$add		= $request->input('add');
		$remove		= $request->input('remove');

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

		return redirect()->route('cp.group.assign', $result->id);
	}
}