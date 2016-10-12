<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

use App\Http\Controllers\CP\AttachmentTrait;
use App\Http\Controllers\QRS\NotificationTrait;

use App\Models\QRS\Complaint;

class ReportController extends Controller
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
				$result->tab = 'report';

				return view('qrs.report.index', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function edit($id)
	{
		if ($result	= Complaint::find($id))
		{
			if ($result->IsCaseLeader() && $result->IsReportNotLock() && $result->IsNotLock())
			{
				$result->tab = 'report';

				return view('qrs.report.edit', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'caseleader_finding'		=> 'required',
			'caseleader_rootcause'		=> 'required',
			'caseleader_corrective'		=> 'required',
			'caseleader_completed_at'	=> 'required',
		]);

		$date	= DateTime::createFromFormat('d/m/Y', $request->input('caseleader_completed_at'));
		$model	= Complaint::find($id);

		$model->caseleader_finding		= $request->input('caseleader_finding');
		$model->caseleader_rootcause	= $request->input('caseleader_rootcause');
		$model->caseleader_corrective	= $request->input('caseleader_corrective');
		$model->caseleader_completed_at	= $date->format('Y-m-d');

		$model->caseleader_updator_id	= auth()->user()->id;
		$model->caseleader_updated_at	= Carbon::now();

		$model->save();

		return redirect()->route('qrs.report.index', $model->id);
	}

	public function attachment($id)
	{
		if ($result = Complaint::find($id))
		{
			if (($result->IsCaseLeader() || $result->IsAssistant()) && $result->IsNotLock())
			{
				$data['refno']		= $result->refno;
				$data['uploader']	= route('qrs.report.attachment.post', $result->id);

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
				$path	= 'attachments/qrs/'.$result->refno.'/report/';
				$id		= $this->fileUpload($file, $path);

				if ($id)
				{
					$result->attachment()->attach($id, ['section' => 'report']);

					return response('SUCCESS', 200);
				}

				return response('ERROR', 500);
			}

			return response('ACCESS DENIED', 403);
		}

		return response('NOT FOUND', 404);
	}

	public function notify($type, $id)
	{
		if ($result = Complaint::find($id))
		{
			if (($result->IsCaseLeader() || $result->IsAssistant()) && in_array($type, ['attachment', 'report']) && $result->IsNotLock())
			{
				$result->tab		= 'report';
				$data['url']		= route('qrs.report.send', [$type, $result->id]);
				$data['previous']	= url()->previous();

				return view('qrs.main.notify', compact('result', 'data'));
			}

			abort(403);
		}

		abort(404);
	}

	public function send(Request $request, $type, $id)
	{
		if ($request->ajax() && in_array($type, ['attachment', 'report']))
		{
			if ($result = Complaint::find($id))
			{
				$status	= $this->notification($result, $type);

				return response($status['message'], $status['code']);
			}

			abort(404);
		}

		abort(403);
	}
}