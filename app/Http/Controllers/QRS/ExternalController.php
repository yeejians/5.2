<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

use App\Http\Controllers\CP\AttachmentTrait;
use App\Models\QRS\Complaint;

class ExternalController extends Controller
{
	use AttachmentTrait;

	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
    }

	public function index($id)
	{
		if ($result	= Complaint::find($id))
		{
			if ($result->CanView())
			{
				$result->tab = 'external';

				return view('qrs.external.index', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function edit($id)
	{
		if ($result	= Complaint::find($id))
		{
			if ($result->isAdmin())
			{
				$result->tab = 'external';

				return view('qrs.external.edit', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request,
			['external_at' => 'required_if:external_info,1|date_format:d/m/Y'],
			['external_at.required_if' => 'Submit date is required.', 'external_at.date_format' => 'The submit date does not match the format dd/mm/yyyy']);

		$date	= DateTime::createFromFormat('d/m/Y', $request->input('external_at'));
		$model	= Complaint::find($id);

		$model->external_info		= $request->input('external_info');

		if ($model->external_info)
		{
			$model->external_at		= $date->format('Y-m-d');
			$model->external_remark	= $request->input('external_remark');
		}

		$model->external_updator_id	= auth()->user()->id;
		$model->external_updated_at	= Carbon::now();

		$model->save();

		return redirect()->route('qrs.external.index', $model->id);
	}

	public function attachment($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->isAdmin())
			{
				$data['refno']		= $result->refno;
				$data['uploader']	= route('qrs.external.attachment.post', $result->id);

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
				$path	= 'attachments/qrs/'.$result->refno.'/external/';
				$id		= $this->fileUpload($file, $path);

				if ($id)
				{
					$result->attachment()->attach($id, ['section' => 'external']);

					return response('SUCCESS', 200);
				}

				return response('ERROR', 500);
			}

			return response('ACCESS DENIED', 403);
		}

		return response('NOT FOUND', 404);
	}
}