<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\CP\AttachmentTrait;
use App\Http\Controllers\QRS\oldAttachmentTrait;

use App\Models\QRS\Complaint;

class SummaryController extends Controller
{
	use AttachmentTrait;
	use oldAttachmentTrait;

	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
    }

	public function index($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->isAdmin())
			{
				$result->tab = 'summary';

				return view('qrs.summary.index', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function indexPost(Request $request, $id)
	{
		$remove	= $request->input('remove');
		$old	= $request->input('removeold');

		if (count($remove) > 0)
		{
			$this->fileDelete($remove);
		}

		if (count($old) > 0)
		{
			$this->olddelete($old);
		}

		return redirect()->route('qrs.summary.index', $id);
	}

	public function edit($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->isAdmin())
			{
				$result->tab = 'summary';

				return view('qrs.summary.edit', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$edit	= $request->input('edit');
		$name	= $request->input('name');

		if (is_array($edit))
		{
			foreach ($edit as $key)
			{
				$this->fileRename($key, $name[$key]);
			}
		}

		return redirect()->route('qrs.summary.index', $id);
	}
}