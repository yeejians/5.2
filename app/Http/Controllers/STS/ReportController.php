<?php

namespace App\Http\Controllers\STS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\STS\Report;

class ReportController extends Controller
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

		return view('sts.report.index', compact('result'));
	}

	public function create()
	{
		return view('sts.report.create');
	}

	public function createPost(Request $request)
	{
		$this->validate($request, [
			'title'		=> 'required|unique:L5_reports',
			'filename'	=> 'required',
			'filepath'	=> 'required',
			'routename'	=> 'required',
		]);

		$model				= new Report;
		$model->title		= $request->input('title');
		$model->filename	= $request->input('filename');
		$model->filepath	= $request->input('filepath');
		$model->routename	= $request->input('routename');
		$model->save();

		return redirect()->route('sts.report.index');
	}

	public function edit($id = null)
	{
		if ($result = Report::find($id))
		{
			return view('sts.report.edit', compact('result'));
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'title'		=> 'required|unique:L5_reports,title,'.$id,
			'filename'	=> 'required',
			'filepath'	=> 'required',
			'routename'	=> 'required',
		]);

		$model				 = Report::find($id);
		$model->title		= $request->input('title');
		$model->filename	= $request->input('filename');
		$model->filepath	= $request->input('filepath');
		$model->routename	= $request->input('routename');
		$model->save();

		return redirect()->route('sts.report.show', $model->id);
	}

	public function show($id)
	{
		if ($result = Report::find($id))
		{
			return view('sts.report.show', compact('result'));
		}

		abort(404);
	}

	public function delete($id)
	{
		if ($result = Report::find($id))
		{
			$result->delete();

			return redirect()->route('sts.report.index');
		}

		abort(404);
	}
}