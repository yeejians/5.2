<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\CP\AttachmentTrait;
use App\Http\Controllers\QRS\NotificationTrait;

use App\Models\QRS\Complaint;

class VerificationController extends Controller
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
				$result->tab = 'verification';

				return view('qrs.verification.index', compact('result'));
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
				$result->tab = 'verification';

				return view('qrs.verification.edit', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'verification'		=> 'required',
		]);

		$model = Complaint::find($id);

		$model->verification = $request->input('verification');
		$model->closed		 = $request->input('closed');
		$model->locked		 = $request->input('locked');

		$model->verification_updator_id	= auth()->user()->id;
		$model->verification_updated_at	= Carbon::now();

		$model->save();

		return redirect()->route('qrs.verification.index', $model->id);
	}

	public function attachment($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsAdmin())
			{
				$data['refno']		= $result->refno;
				$data['uploader']	= route('qrs.verification.attachment.post', $result->id);

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
				$path	= 'attachments/qrs/'.$result->refno.'/verification/';
				$id		= $this->fileUpload($file, $path);

				if ($id)
				{
					$result->attachment()->attach($id, ['section' => 'verification']);

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
			if ($result->IsAdmin())
			{
				$result->tab		= 'verification';
				$data['url']		= route('qrs.verification.send', $result->id);
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
				$status	= $this->notification($result, 'verification');

				return response($status['message'], $status['code']);
			}

			abort(404);
		}

		abort(403);
	}

	public function lock($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsAdmin())
			{
				$result->locked						= 1;
				$result->verification_updator_id	= auth()->user()->id;
				$result->verification_updated_at	= Carbon::now();
				$result->save();

				return redirect()->route('qrs.verification.index', $result->id);
			}

			abort(403);
		}

		abort(404);
	}

	public function unlock($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsAdmin())
			{
				$result->locked						= 0;
				$result->verification_updator_id	= auth()->user()->id;
				$result->verification_updated_at	= Carbon::now();
				$result->save();

				return redirect()->route('qrs.verification.index', $result->id);
			}

			abort(403);
		}

		abort(404);
	}
}