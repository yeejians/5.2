<?php

namespace App\Http\Controllers\QRS;

use App\Models\QRS\Notification;
use App\Models\QRS\Member;
use Mail;

trait NotificationTrait
{
	protected function notification($result, $type)
	{
		$to			= [];
		$cc			= [];

		$to	= $this->fetchlist('to', $type, $result);
		$cc	= $this->fetchlist('cc', $type, $result);

		if (empty($to))
		{
			$status['message']	= 'RECIPIENT NOT FOUND';
			$status['code']		= 404;
			return $status;
		}

		$assistants	= $this->fetchname($result->assistant);
		$update		= $this->updatestatus($result, $type);

		$input	= [
			'@QRNumber@',
			'@Customer@',
			'@Initiator@',
			'@QAPIC@',
			'@Caseleader@',
			'@Assistants@',
			'@Feedbackby@',
			'@Assistant@',
			'@Reportby@',
			'@Reviewby@',
			'@Verifyby@',
			'@FinalResponse@'
		];

		$output	= [
			$result->refno,
			$result->customer_name,
			$result->creator(),
			$result->GetQAPIC(),
			$result->GetCaseleader(),
			$assistants,
			$result->GetLastFeedbackUser(),
			$result->GetLastAssistantUpload(),
			$result->GetReportedUser(),
			$result->GetReviewedUser(),
			$result->GetVerifiedUser(),
			$result->GetRespondUser()
		];

		$subject = str_replace($input, $output, html_entity_decode($result->notification->subject));
		$content = str_replace($input, $output, html_entity_decode($result->notification->message));

/********************************************** Receipient Simulation Start *************************************************************************/
		$addto = '';
		$addcc = '';

		foreach ($to as $t)
		{
			$addto .= $t['name'].' &lt;'.$t['email'].'&gt;; ';
		}

		foreach ($cc as $c)
		{
			$addcc .= $c['name'].' &lt;'.$c['email'].'&gt;; ';
		}

		$header = '<b>To:</b> '.$addto.'<br /><b>Cc:</b> '.$addcc.'<br />-------------------------------------------------------<br /><br />';
		$content = $header.$content;
/********************************************** Receipient Simulation End *************************************************************************/

		$status	= $this->email($subject, $content, $to, $cc, $result);

		return $status;
	}

	private function email($subject, $content, $to, $cc, $result)
	{
		Mail::send('qrs.main.mail', compact('content', 'result'), function($email) use ($to, $cc, $subject)
		{
			$email->from(config('mail.from.address'), 'Quality Reactor System');
			$email->bcc(config('mail.bcc.address'), config('mail.bcc.name'));
			$email->replyTo(config('mail.reply.address'), config('mail.reply.name'));

			$email->to('yeekin.lam@ioiloders.com', 'Lam, Yee Kin');
/*
			foreach ($to as $t)
			{
				$email->to($t['email'], $t['name']);
			}

			if (count($cc) > 0)
			{
				foreach ($cc as $c)
				{
					$email->cc($c['email'], $c['name']);
				}
			}
*/
			$email->subject($subject);
		});

		$status['message']	= 'SUCCESS';
		$status['code']		= 200;

		return $status;
	}

	private function updatestatus($result, $status)
	{
		$notification				= Notification::where('prefixkey', $status)->first();
		$result->notification_id	= $notification->id;
		
		return $result->save() ? true : false;
	}

	private function fetchname($result)
	{
		$lists	= '';

		foreach ($result as $name)
		{
			$lists	.= $name->display_name.'<br />';
		}

		return $lists;
	}

	private function fetchgroup($result, $namelist, $group)
	{
		$defaultcc	= Member::where('name', 'QR.DefaultCc')->first();
		$cocmember	= Member::where('name', 'QR.Claims')->first();

		switch ($group)
		{
			case 'assistant':
				foreach ($result->assistant as $key)
				{
					$namelist = array_add($namelist, $key->id,	['email' => $key->email,	'name' => $key->display_name]);
				}
				break;
			case 'sales':
				foreach ($result->sales as $key)
				{
					$namelist = array_add($namelist, $key->id,	['email' => $key->email,	'name' => $key->display_name]);
				}
				break;
			case 'additional':
				foreach ($result->additional as $key)
				{
					$namelist = array_add($namelist, $key->id,	['email' => $key->email,	'name' => $key->display_name]);
				}
				break;
			case 'defaultqa':
				foreach ($result->defaultqa as $key)
				{
					$namelist = array_add($namelist, $key->id,	['email' => $key->email,	'name' => $key->display_name]);
				}
				break;
			case 'defaultcc':
				foreach ($defaultcc->user as $key)
				{
					$namelist = array_add($namelist, $key->id,	['email' => $key->email,	'name' => $key->display_name]);
				}
				break;
			case 'cocmember':
				foreach ($cocmember->user as $key)
				{
					$namelist = array_add($namelist, $key->id,	['email' => $key->email,	'name' => $key->display_name]);
				}
				break;
			case 'map-qa':
				$namelist	 = array_add($namelist, 'MAP-QA', 					['email' => 'map-qa@ioiloders.com', 'name' => 'MAP-QA']);
				break;
			case 'initiator':
				if ($result->IsActiveUser($group))
				{
					$namelist = array_add($namelist, $result->creator_id,		['email' => $result->initiator->email, 'name' => $result->creator()]);
				}
				break;
			case 'qapic':
				if ($result->IsActiveUser($group))
				{
					$namelist = array_add($namelist, $result->qa->id, 			['email' => $result->qa->email, 'name' => $result->qa->display_name]);
				}
				break;
			case 'caseleader':
				if ($result->IsActiveUser($group))
				{
					$namelist = array_add($namelist, $result->caseleader->id,	['email' => $result->caseleader->email, 'name' => $result->caseleader->display_name]);
				}
				break;
			default:
				return $namelist;
		}

		return $namelist;
	}

	private function fetchlist($recipient, $type, $result)
	{
		$namelist	= [];

		if ($type == 'initiation')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'initiator');
				$namelist = $this->fetchgroup($result, $namelist, 'sales');
				$namelist = $this->fetchgroup($result, $namelist, 'defaultcc');

				return $namelist;
			}
		}

		if ($type == 'assignment')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'qapic');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');

				return $namelist;
			}
		}

		if ($type == 'caseleader')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'caseleader');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');
				$namelist = $this->fetchgroup($result, $namelist, 'additional');

				return $namelist;
			}
		}

		if ($type == 'assistant')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'assistant');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'caseleader');
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');

				return $namelist;
			}
		}

		if ($type == 'feedback')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'initiator');
				$namelist = $this->fetchgroup($result, $namelist, 'qapic');
				$namelist = $this->fetchgroup($result, $namelist, 'caseleader');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'sales');
				$namelist = $this->fetchgroup($result, $namelist, 'assistant');
				$namelist = $this->fetchgroup($result, $namelist, 'additional');
				$namelist = $this->fetchgroup($result, $namelist, 'defaultqa');

				return $namelist;
			}
		}

		if ($type == 'attachment')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'caseleader');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');
				$namelist = $this->fetchgroup($result, $namelist, 'assistant');

				return $namelist;
			}
		}

		if ($type == 'report')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');
				$namelist = $this->fetchgroup($result, $namelist, 'initiator');
				$namelist = $this->fetchgroup($result, $namelist, 'sales');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'caseleader');
				$namelist = $this->fetchgroup($result, $namelist, 'assistant');
				$namelist = $this->fetchgroup($result, $namelist, 'defaultcc');

				return $namelist;
			}
		}

		if ($type == 'review')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'initiator');
				$namelist = $this->fetchgroup($result, $namelist, 'caseleader');
				$namelist = $this->fetchgroup($result, $namelist, 'assistant');
				$namelist = $this->fetchgroup($result, $namelist, 'sales');
				$namelist = $this->fetchgroup($result, $namelist, 'defaultcc');
				$namelist = $this->fetchgroup($result, $namelist, 'additional');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');

				return $namelist;
			}
		}

		if ($type == 'verification')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'caseleader');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');

				return $namelist;
			}
		}

		if ($type == 'response')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'initiator');
				$namelist = $this->fetchgroup($result, $namelist, 'sales');

				return $namelist;
			}
		}

		if ($type == 'claims')
		{
			if ($recipient == 'to')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'cocmember');
				$namelist = $this->fetchgroup($result, $namelist, 'initiator');
				$namelist = $this->fetchgroup($result, $namelist, 'sales');

				return $namelist;
			}

			if ($recipient == 'cc')
			{
				$namelist = $this->fetchgroup($result, $namelist, 'map-qa');

				return $namelist;
			}
		}

		return $namelist;
	}
}