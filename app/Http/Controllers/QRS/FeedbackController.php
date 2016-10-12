<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\CP\AttachmentTrait;
use App\Http\Controllers\QRS\NotificationTrait;

use App\Models\QRS\Complaint;

class FeedbackController extends Controller
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
				$result->tab = 'feedback';

				return view('qrs.feedback.index', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function create($id)
	{
		if ($result	= Complaint::find($id))
		{
			if ($result->IsNotLock())
			{
				$result->tab = 'feedback';

				return view('qrs.feedback.create', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function createPost(Request $request, $id)
	{
		$this->validate($request, ['comment' => 'required']);

		$model	= Complaint::find($id);

		$model->comments()->create(['comment' => $request->input('comment')]);

//		return redirect()->route('qrs.feedback.notify', $model->id);
		return redirect()->route('qrs.feedback.index', $model->id);
	}

	public function attachment($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsNotLock())
			{
				$data['refno']		= $result->refno;
				$data['uploader']	= route('qrs.feedback.attachment.post', $result->id);

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
				$path	= 'attachments/qrs/'.$result->refno.'/feedback/';
				$id		= $this->fileUpload($file, $path);

				if ($id)
				{
					$result->attachment()->attach($id, ['section' => 'feedback']);

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
			if ($result->IsNotLock())
			{
				$result->tab		= 'feedback';
				$data['url']		= route('qrs.feedback.send', $result->id);
				$data['previous']	= route('qrs.feedback.index', $result->id);

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
				$status	= $this->notification($result, 'feedback');

				return response($status['message'], $status['code']);
			}

			abort(404);
		}

		abort(403);
	}
}