<?php

namespace App\Http\Controllers\QRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

use App\Models\QRS\Notification;
use App\Models\QRS\Reminder;
use App\Models\QRS\Person;

class ReminderController extends Controller
{
	public function __construct()
	{
        $this->middleware('auth');
		$this->middleware('selectdb');
	}

	public function index()
	{
		$user	= Person::find(auth()->user()->id);
		$view	= $user->CanViewAll() ? Reminder::orderBy('pending_day', 'desc') : $user->reminders()->orderBy('pending_day', 'desc');
		$result	= $view->paginate();

		return view('qrs.reminder.index', compact('result'));
	}

    public function notify($id)
	{
		if ($result = Reminder::find($id))
		{
			if ($result->isAdmin())
			{
				$data['url']		= route('qrs.reminder.send', $result->id);
				$data['previous']	= url()->previous();

				return view('qrs.reminder.notify', compact('result', 'data'));
			}

			abort(403);
		}

		abort(404);
	}

	public function send(Request $request, $id)
	{
		if ($request->ajax())
		{
			$result	= Reminder::where('id', $id)->get();

			foreach ($result as $key)
			{
				$to	= ['email' => $key->GetPICEmail(), 'name' => $key->GetPIC()];
			}

			$status	= $this->reminder($result, $to);

			return response($status['message'], $status['code']);
		}

		abort(403);
	}

	public function all()
	{
		$lists	= Reminder::select('pic_id')->distinct()->where('pending_day', '>=', 7)->lists('pic_id');
		$users	= Person::whereIn('id', $lists)->get();

		foreach ($users as $user)
		{
			if ($user->ad_status == 1)
			{
				$result	= $user->reminders()->where('pending_day', '>=', 7)->get();
				$to		= ['email' => $user->email, 'name' => $user->display_name];
				$status	= $this->reminder($result, $to);
			}
		}

		$result	= Reminder::whereNull('pic_id')->get();

		if ($result)
		{
			$to		= ['email' => 'map-qa@ioiloders.com', 'name' => 'MAP-QA'];
			$status	= $this->reminder($result, $to);
		}

		return $status['message'];
	}

	private function reminder($result, $to)
	{
		$template	= Notification::where('prefixkey', 'reminder')->first();
		$input		= ['@Today@'];
		$output		= [date('d/m/Y')];
		$subject	= str_replace($input, $output, html_entity_decode($template->subject));
		$content	= str_replace($input, $output, html_entity_decode($template->message));

/********************************************** Receipient Simulation Start *************************************************************************/
		$addto   = $to['name'].' &lt;'.$to['email'].'&gt;; ';
		$header	 = '<b>To:</b> '.$addto.'<br />-------------------------------------------------------<br /><br />';
		$content = $header.$content;
/********************************************** Receipient Simulation End *************************************************************************/

		Mail::queue('qrs.reminder.mail', compact('content', 'result'), function($email) use ($to, $subject)
		{
			$email->from(config('mail.from.address'), 'Quality Reactor System');
			$email->bcc(config('mail.bcc.address'), config('mail.bcc.name'));
			$email->replyTo(config('mail.reply.address'), config('mail.reply.name'));

			$email->to('yeekin.lam@ioiloders.com', 'Lam, Yee Kin');
//			$email->to($to['email'], $to['name']);

			$email->subject($subject);
		});

		$status['message']	= 'SUCCESS';
		$status['code']		= 200;

		return $status;
	}
}