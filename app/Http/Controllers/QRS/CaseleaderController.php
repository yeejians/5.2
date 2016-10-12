<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\QRS\NotificationTrait;

use App\Models\QRS\Classification;
use App\Models\QRS\Complaint;
use App\Models\QRS\Master;
use App\Models\QRS\Member;
use App\Models\QRS\Person;

class CaseleaderController extends Controller
{
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
				$result->tab = 'caseleader';
				$member		 = Member::where('name', 'QR.DefaultCc')->first();
				$defaultcc	 = $member->user;

				return view('qrs.caseleader.index', compact('result', 'defaultcc'));
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
				$result->tab = 'caseleader';

				$list_assistant	 = $result->assistant()->lists('user_id');
				$list_additional = $result->additional()->lists('user_id');

				$classes		= Master::classification()->get();
				$caseleaders	= Member::where('name', 'QR.Caseleader')->first();
				$assistants		= $list_assistant ? Person::user()->whereNotIn('id', $list_assistant)->get() : Person::user()->get();
				$additionals	= $list_additional ? Person::user()->whereNotIn('id', $list_additional)->get() : Person::user()->get();

				return view('qrs.caseleader.edit', compact('result', 'classes', 'caseleaders', 'assistants', 'additionals'));
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, [
			'subject'			=> 'required',
			'classification_id'	=> 'required',
			'caseleader_id'		=> 'required',
		]);

		$model							= Complaint::find($id);
		$model->subject					= $request->input('subject');
		$model->classification_id		= $request->input('classification_id');
		$model->caseleader_id			= $request->input('caseleader_id');

		$model->caseleader_assigned_id	= auth()->user()->id;
		$model->caseleader_assigned_at	= Carbon::now();

		if ($model->save())
		{
			$assistants			= $request->input('assistant');
			$removeassistant	= $request->input('removeassistant');
			$additionals		= $request->input('additional');
			$removeadditional	= $request->input('removeadditional');

			if (is_array($removeassistant))
			{
				$model->cclist()->where('cctype', 'assistant')->whereIn('user_id', $removeassistant)->get()->each(function($list){$list->delete();});
			}

			if (is_array($removeadditional))
			{
				$model->cclist()->where('cctype', 'additional')->whereIn('user_id', $removeadditional)->get()->each(function($list){$list->delete();});
			}

			if (is_array($assistants))
			{
				foreach ($assistants as $assistant)
				{
					$model->cclist()->create([
						'user_id'	=> $assistant,
						'cctype'	=> 'assistant']);
				}
			}

			if (is_array($additionals))
			{
				foreach ($additionals as $additional)
				{
					$model->cclist()->create([
						'user_id'	=> $additional,
						'cctype'	=> 'additional']);
				}
			}
		}

		return redirect()->route('qrs.caseleader.index', $model->id);
	}

	public function notify($type, $id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->isAdmin() && in_array($type, ['caseleader', 'assistant']))
			{
				$result->tab		= 'caseleader';
				$data['url']		= route('qrs.caseleader.send', [$type, $result->id]);
				$data['previous']	= url()->previous();

				return view('qrs.main.notify', compact('result', 'data'));
			}

			abort(403);
		}

		abort(404);
	}

	public function send(Request $request, $type, $id)
	{
		if ($request->ajax() && in_array($type, ['caseleader', 'assistant']))
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