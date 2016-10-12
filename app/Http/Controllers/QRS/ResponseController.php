<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\CP\AttachmentTrait;
use App\Http\Controllers\QRS\NotificationTrait;

use App\Models\QRS\Complaint;

class ResponseController extends Controller
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
			if ($result->CanView())
			{
				$result->tab = 'response';

				return view('qrs.response.index', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function edit($id)
	{
		if ($result	= Complaint::find($id))
		{
			if ($result->IsInitiator() || $result->IsSalesCc())
			{
				$result->tab = 'response';

				return view('qrs.response.edit', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'finalresponse'		=> 'required',
		]);

		$model = Complaint::find($id);

		$model->finalresponse = $request->input('finalresponse');

		$model->finalresponse_updator_id	= auth()->user()->id;
		$model->finalresponse_updated_at	= Carbon::now();

		$model->save();

		return redirect()->route('qrs.response.index', $model->id);
	}

	public function attachment($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsInitiator() || $result->IsSalesCc())
			{
				$data['refno']		= $result->refno;
				$data['uploader']	= route('qrs.response.attachment.post', $result->id);

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
				$path	= 'attachments/qrs/'.$result->refno.'/response/';
				$id		= $this->fileUpload($file, $path);

				if ($id)
				{
					$result->attachment()->attach($id, ['section' => 'response']);

					return response('SUCCESS', 200);
				}

				return response('ERROR', 500);
			}

			return response('ACCESS DENIED', 403);
		}

		return response('NOT FOUND', 404);
	}

	public function notify($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsInitiator() || $result->IsSalesCc())
			{
				$result->tab		= 'response';
				$data['url']		= route('qrs.response.send', $result->id);
				$data['previous']	= url()->previous();

				return view('qrs.main.notify', compact('result', 'data'));
			}

			abort(403);
		}

		abort(404);
	}

	public function send(Request $request, $id)
	{
		if ($request->ajax())
		{
			if ($result = Complaint::find($id))
			{
				$status	= $this->notification($result, 'response');

				return response($status['message'], $status['code']);
			}

			abort(404);
		}

		abort(403);
	}
}