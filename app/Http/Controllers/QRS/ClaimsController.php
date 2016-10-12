<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mail;

use App\Http\Controllers\CP\AttachmentTrait;
use App\Http\Controllers\QRS\NotificationTrait;

use Libraries\Crystal;

use App\Models\QRS\Complaint;
use App\Models\QRS\Claims;
use App\Models\QRS\Comment;
use App\Models\QRS\Master;
use App\Models\QRS\Member;

class ClaimsController extends Controller
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
		if ($id == 'autosend')
		{
			return $this->autosend();
		}

		if ($result	= Complaint::find($id))
		{
			if ($result->CanView())
			{
				$result->tab = 'claims';

				return view('qrs.claims.index', compact('result'));
			}

			abort(403);
		}

		abort(404);
	}

	public function indexPost(Request $request, $id)
	{
		$remove		= $request->input('remove');
		$comment	= $request->input('comment');

		if ($comment)
		{
			$model	= new Comment;

			$model->comment			= $comment;
			$model->complaint_id	= $id;
			$model->section			= 'claims';
			$model->save();
		}

		if (is_array($remove))
		{
			Claims::destroy($remove);
		}

		return redirect()->route('qrs.claims.index', $id);
	}

	public function create($id)
	{
		if ($result	= Complaint::find($id))
		{
			if ($result->IsCanClaim())
			{
				$result->tab	= 'claims';

				$claimstype		= Master::claimstype()->get();
				$documents		= Master::document()->get();
				$currencies		= Master::currency()->get();

				return view('qrs.claims.create', compact('result', 'claimstype', 'documents', 'currencies'));
			}
			abort(403);
		}

		abort(404);
	}

	public function createPost(Request $request, $id)
	{
		$this->validate($request, [
			'claimstype_id'	=> 'required',
			'document_id'	=> 'required',
			'currency_id'	=> 'required',
			'refno'			=> 'required',
			'rate'			=> 'required|numeric',
			'amount'		=> 'required|numeric',
		]);

		$model = new Claims;

		$model->claimtype_id	= $request->input('claimstype_id');
		$model->document_id		= $request->input('document_id');
		$model->currency_id		= $request->input('currency_id');
		$model->refno			= $request->input('refno');
		$model->rate			= $request->input('rate');
		$model->amount			= $request->input('amount');
		$model->remarks			= $request->input('remarks');
		$model->local			= $model->rate * $model->amount;
		$model->complaint_id	= $id;
		$model->save();

		return redirect()->route('qrs.claims.index', $id);
	}

	public function edit($cid, $id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsCanClaim())
			{
				if ($claim = Claims::find($cid))
				{
					$result->tab	= 'claims';

					$claimstype		= Master::claimstype()->get();
					$documents		= Master::document()->get();
					$currencies		= Master::currency()->get();

					return view('qrs.claims.edit', compact('result', 'claim', 'claimstype', 'documents', 'currencies'));
				}
				
				abort(404);
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $cid, $id)
	{
		$this->validate($request, [
			'claimstype_id'	=> 'required',
			'document_id'	=> 'required',
			'currency_id'	=> 'required',
			'refno'			=> 'required',
			'rate'			=> 'required|numeric',
			'amount'		=> 'required|numeric',
		]);

		$model = Claims::find($cid);

		$model->claimtype_id	= $request->input('claimstype_id');
		$model->document_id		= $request->input('document_id');
		$model->currency_id		= $request->input('currency_id');
		$model->refno			= $request->input('refno');
		$model->rate			= $request->input('rate');
		$model->amount			= $request->input('amount');
		$model->remarks			= $request->input('remarks');
		$model->local			= $model->rate * $model->amount;
		$model->save();

		return redirect()->route('qrs.claims.index', $id);
	}

	public function attachment($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsCanClaim())
			{
				$data['refno']		= $result->refno;
				$data['uploader']	= route('qrs.claims.attachment.post', $result->id);

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
				$path	= 'attachments/qrs/'.$result->refno.'/claims/';
				$id		= $this->fileUpload($file, $path);

				if ($id)
				{
					$result->attachment()->attach($id, ['section' => 'claims']);

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
			if ($result->IsCanClaim())
			{
				$result->tab		= 'claims';
				$data['url']		= route('qrs.claims.send', $result->id);
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
				$status	= $this->notification($result, 'claims');

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
			if ($result->IsCocMember())
			{
				$result->lockclaim				= 1;
				$result->lockclaim_updator_id	= auth()->user()->id;
				$result->lockclaim_updated_at	= Carbon::now();
				$result->save();

				return redirect()->route('qrs.claims.index', $result->id);
			}

			abort(403);
		}

		abort(404);
	}

	public function unlock($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->IsCocMember())
			{
				$result->lockclaim				= 0;
				$result->lockclaim_updator_id	= auth()->user()->id;
				$result->lockclaim_updated_at	= Carbon::now();
				$result->save();

				return redirect()->route('qrs.claims.index', $result->id);
			}

			abort(403);
		}

		abort(404);
	}

	public function autosend()
	{
		$name		= 'claims.rpt';
		$filename	= $name.'.'.time().'.pdf';
		$rpt		= base_path().'/reports/qrs/'.$name;
		$file		= base_path().'/storage/reports/'.$filename;

		$report		= Crystal::ReportGet($rpt);

		Crystal::ReportExport($report, $file);

		$subject	= 'Cost of Claims Report as on '.date('d/m/Y');
		$content	= '';

		$to			= Member::claims()->get();

/********************************************** Receipient Simulation Start *************************************************************************/
		$addto		= '';

		foreach ($to as $t)
		{
			$addto .= $t->user->display_name.' &lt;'.$t->user->email.'&gt;; ';
		}

		$header = '<b>To:</b> '.$addto.'<br />-------------------------------------------------------<br /><br />';
		$content = $header.$content;
/********************************************** Receipient Simulation End *************************************************************************/

		Mail::send('emails.mail', ['content' => $content], function($email) use ($subject, $to, $file)
		{
			$email->from(config('mail.from.address'), 'Quality Reactor System');
			$email->bcc(config('mail.bcc.address'), config('mail.bcc.name'));
			$email->replyTo(config('mail.reply.address'), config('mail.reply.name'));

			$email->to('yeekin.lam@ioiloders.com', 'Lam, Yee Kin');

/*			foreach ($to as $TO)
			{
				$email->to($TO->user->email, $TO->user->display_name);
			}

			$mail->cc('map-qa@ioiloders.com', 'MAP-QA');
*/
			$email->subject($subject);
			$email->attach($file);
		});

		return 'OK';
	}
}