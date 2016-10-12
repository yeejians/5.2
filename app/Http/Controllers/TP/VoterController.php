<?php

namespace App\Http\Controllers\TP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CP\Person;
use App\Models\CP\Site;
use App\Models\TP\Voter;

class VoterController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
		$this->middleware('access');
    }

	public function index()
	{
		$result = Voter::orderBy('site_id', 'ASC')->get();

		return view('tp.voter.index', compact('result'));
	}

	public function create()
	{
		$sites	= Site::all();
		$users	= Person::active()->get();

		return view('tp.voter.create', compact('sites', 'users'));
	}

	public function createPost(Request $request)
	{
		$this->validate($request, [
			'department'	=> 'required',
			'user_id'		=> 'required|unique:voters',
			'site_id'		=> 'required',
		]);

		$model				= new Voter;
		$model->department	= $request->input('department');
		$model->user_id		= $request->input('user_id');
		$model->site_id		= $request->input('site_id');
		$model->save();

		return redirect()->route('tp.voter.index');
	}

	public function edit($id = null)
	{
		if ($result = Voter::find($id))
		{
			$sites	= Site::all();
			$users	= Person::active()->get();

			return view('tp.voter.edit', compact('result', 'sites', 'users'));
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'department'	=> 'required',
			'user_id'		=> 'required|unique:voters,user_id,'.$id,
			'site_id'		=> 'required',
		]);

		$model				= Voter::find($id);
		$model->department	= $request->input('department');
		$model->user_id		= $request->input('user_id');
		$model->site_id		= $request->input('site_id');
		$model->save();

		return redirect()->route('tp.voter.show', $model->id);
	}

	public function show($id = null)
	{
		if ($result = Voter::find($id))
		{
			return view('tp.voter.show', compact('result'));
		}

		abort(404);
	}

	public function delete($id)
	{
		if ($result = Voter::find($id))
		{
			$result->delete();

			return redirect()->route('tp.voter.index');
		}

		abort(404);
	}

	public function backup($id = null)
	{
		if ($result = Voter::find($id))
		{
			$users	= Person::active()->whereNotIn('id', $result->backup()->lists('user_id'))->get();

			return view('tp.voter.backup', compact('result', 'users'));
		}

		abort(404);
	}

	public function backupPost(Request $request, $id = null)
	{
		$result		= Voter::find($id);
		$add		= $request->input('add');
		$remove		= $request->input('remove');

		if (is_array($add))
		{
			foreach ($add as $addUser)
			{
				$result->backup()->create([
					'user_id' => $addUser,
				]);
			}
		}

		if (is_array($remove))
		{
			$result->backup()->whereIn('id', $remove)->delete();
		}

		return redirect()->route('tp.voter.show', $result->id);
	}
}