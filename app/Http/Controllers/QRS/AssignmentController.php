<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\QRS\NotificationTrait;

use App\Models\QRS\Complaint;
use App\Models\QRS\Person;

class AssignmentController extends Controller
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
				$result->tab = 'assignment';

				return view('qrs.assignment.index', compact('result'));
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
				$result->tab = 'assignment';

				$qalist	= Person::qa()->get();
				$list	= $result->defaultqa()->lists('user_id');
				$lists	= $list ? Person::qa()->whereNotIn('id', $list)->get() : Person::qa()->get();

				return view('qrs.assignment.edit', compact('result', 'qalist', 'lists'));
			}

			abort(403);
		}

		abort(404);
	}

	public function editPost(Request $request, $id)
	{
		$this->validate($request, ['qa_id' => 'required',]);

		$model					= Complaint::find($id);
		$model->qa_id			= $request->input('qa_id');
		$model->qa_assigned_id	= auth()->user()->id;
		$model->qa_assigned_at	= Carbon::now();

		if ($model->save())
		{
			$add	= $request->input('add');
			$remove	= $request->input('remove');

			if (is_array($remove))
			{
				$model->cclist()->where('cctype', 'defaultqa')->whereIn('user_id', $remove)->get()->each(function($list){$list->delete();});
			}

			if (is_array($add))
			{
				foreach ($add as $id)
				{
					$model->cclist()->create([
						'user_id'	=> $id,
						'cctype'	=> 'defaultqa']);
				}
			}
		}

		return redirect()->route('qrs.assignment.index', $model->id);
	}

	public function notify($id)
	{
		if ($result = Complaint::find($id))
		{
			if ($result->isAdmin())
			{
				$result->tab		= 'assignment';
				$data['url']		= route('qrs.assignment.send', $result->id);
				$data['previous']	= url()->previous();

				return view('qrs.main.notify', compact('result', 'data'));
			}
		}

		abort(404);
	}

	public function send(Request $request, $id)
	{
		if ($request->ajax())
		{
			if ($result = Complaint::find($id))
			{
				$status	= $this->notification($result, 'assignment');

				return response($status['message'], $status['code']);
			}

			abort(404);
		}

		abort(403);
	}
}