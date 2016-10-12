<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\CP\AttachmentTrait;

use App\Models\QRS\Complaint;

class InformationController extends Controller
{
	use AttachmentTrait;
	use NotificationTrait;

	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
    }

	public function index($id)
	{
		if ($result	= Complaint::find($id))
		{
			if ($result->IsAdmin())
			{
				$result->tab = 'information';

				return view('qrs.information.index', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function edit($id)
	{
		if ($result	= Complaint::find($id))
		{
			if ($result->IsAdmin())
			{
				$result->tab = 'information';

				return view('qrs.information.edit', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'information'		=> 'required',
		]);

		$model = Complaint::find($id);

		$model->information = $request->input('information');

		$model->information_updator_id	= auth()->user()->id;
		$model->information_updated_at	= Carbon::now();

		$model->save();

		return redirect()->route('qrs.information.index', $model->id);
	}

	public function attachment($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsAdmin())
			{
				$data['refno']		= $result->refno;
				$data['uploader']	= route('qrs.information.attachment.post', $result->id);

				return view('home.upload', compact('data'));
			}

			abort(403);
		}

		abort(404);
	}

	public function attachmentPost(Request $request, $id)
	{
		$file	= $request->file('Filedata');

		if ($result = Complaint::find($id))
		{
			if ($file->isValid())
			{
				$path	= 'attachments/qrs/'.$result->refno.'/information/';
				$id		= $this->fileUpload($file, $path);

				if ($id)
				{
					$result->attachment()->attach($id, ['section' => 'information']);

					return response('SUCCESS', 200);
				}

				return response('ERROR', 500);
			}

			return response('ACCESS DENIED', 403);
		}

		return response('NOT FOUND', 404);
	}
}