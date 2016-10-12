<?php

namespace App\Models\QRS;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

use App\Models\QRS\Calendar;

class Complaint extends Based
{
	use Activitylog;
	use SoftDeletes;

	protected $table = 'complaints';
	protected $dates = [
		'deleted_at',
		'date',
		'qa_assigned_at',
		'qa_updated_at',
		'caseleader_assigned_at',
		'caseleader_completed_at',
		'caseleader_updated_at',
		'external_at',
		'external_updated_at',
		'verification_updated_at',
		'finalresponse_updated_at',
		'information_updated_at',
		'lockclaim_updator_at'
	];

	public function cclist()
	{
		return $this->hasMany('App\Models\QRS\Cclist', 'complaint_id');
	}

	public function comments()
	{
		return $this->hasMany('App\Models\QRS\Comment', 'complaint_id')->where('section', 'feedback');
	}

	public function commentc()
	{
		return $this->hasMany('App\Models\QRS\Comment', 'complaint_id')->where('section', 'claims')->orderBy('created_at', 'desc');
	}

	public function feedbacks()
	{
		return $this->hasMany('App\Models\QRS\Feedback', 'complaint_id')->orderBy('created_at', 'desc');
	}

	public function claims()
	{
		return $this->hasMany('App\Models\QRS\Claims', 'complaint_id');
	}

	public function site()
	{
		return $this->belongsTo('App\Models\QRS\Site', 'site_id');
	}

	public function initiator()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'creator_id');
	}

	public function country()
	{
		return $this->belongsTo('App\Models\QRS\Master', 'country_id');
	}

	public function packing()
	{
		return $this->belongsTo('App\Models\QRS\Master', 'pack_id');
	}

	public function stuffing()
	{
		return $this->belongsTo('App\Models\QRS\Master', 'stuff_id');
	}

	public function classification()
	{
		return $this->belongsTo('App\Models\QRS\Master', 'classification_id');
	}

	public function notification()
	{
		return $this->belongsTo('App\Models\QRS\Notification', 'notification_id');
	}

	public function caseleader()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'caseleader_id');
	}

	public function qa()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'qa_id');
	}

	public function assignor()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'qa_assigned_id');
	}

	public function caseleador()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'caseleader_assigned_id');
	}

	public function externor()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'external_updator_id');
	}

	public function reportor()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'caseleader_updator_id');
	}

	public function reviewor()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'qa_updator_id');
	}

	public function verifior()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'verification_updator_id');
	}

	public function respondor()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'finalresponse_updator_id');
	}

	public function informator()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'information_updator_id');
	}

	public function claimor()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'lockclaim_updator_id');
	}

	public function sales()
	{
		return $this->belongsToMany('App\Models\QRS\Person', 'complaint_cclist', 'complaint_id', 'user_id')->wherePivot('cctype', 'sales');
	}

	public function defaultqa()
	{
		return $this->belongsToMany('App\Models\QRS\Person', 'complaint_cclist', 'complaint_id', 'user_id')->wherePivot('cctype', 'defaultqa');
	}

	public function additional()
	{
		return $this->belongsToMany('App\Models\QRS\Person', 'complaint_cclist', 'complaint_id', 'user_id')->wherePivot('cctype', 'additional');
	}

	public function assistant()
	{
		return $this->belongsToMany('App\Models\QRS\Person', 'complaint_cclist', 'complaint_id', 'user_id')->wherePivot('cctype', 'assistant');
	}

	public function attachment()
	{
		return $this->belongsToMany('App\Models\CP\Attachment', 'complaint_attachment', 'complaint_id', 'attachment_id')->withPivot('section')->orderBy('section');
	}

	public function fileInitiation()
	{
		return $this->belongsToMany('App\Models\CP\Attachment', 'complaint_attachment', 'complaint_id', 'attachment_id')->wherePivot('section', 'initiation')->orderBy('attachments.image');
	}

	public function fileExternal()
	{
		return $this->belongsToMany('App\Models\CP\Attachment', 'complaint_attachment', 'complaint_id', 'attachment_id')->wherePivot('section', 'external')->orderBy('attachments.image');
	}

	public function fileReport()
	{
		return $this->belongsToMany('App\Models\CP\Attachment', 'complaint_attachment', 'complaint_id', 'attachment_id')->wherePivot('section', 'report')->orderBy('attachments.image');
	}

	public function fileReview()
	{
		return $this->belongsToMany('App\Models\CP\Attachment', 'complaint_attachment', 'complaint_id', 'attachment_id')->wherePivot('section', 'review')->orderBy('attachments.image');
	}

	public function fileVerification()
	{
		return $this->belongsToMany('App\Models\CP\Attachment', 'complaint_attachment', 'complaint_id', 'attachment_id')->wherePivot('section', 'verification')->orderBy('attachments.image');
	}

	public function fileResponse()
	{
		return $this->belongsToMany('App\Models\CP\Attachment', 'complaint_attachment', 'complaint_id', 'attachment_id')->wherePivot('section', 'response')->orderBy('attachments.image');
	}

	public function fileInformation()
	{
		return $this->belongsToMany('App\Models\CP\Attachment', 'complaint_attachment', 'complaint_id', 'attachment_id')->wherePivot('section', 'information')->orderBy('attachments.image');
	}

	public function fileClaims()
	{
		return $this->belongsToMany('App\Models\CP\Attachment', 'complaint_attachment', 'complaint_id', 'attachment_id')->wherePivot('section', 'claims')->orderBy('attachments.image');
	}

	public function IsInitiator()
	{
		if ($this->isAdmin())
		{
			return true;
		}

		return $this->creator_id == auth()->user()->id ? true : false;
	}

	public function IsQAPIC()
	{
		if ($this->isAdmin())
		{
			return true;
		}

		return $this->qa_id == auth()->user()->id ? true : false;
	}

	public function IsCaseLeader()
	{
		if ($this->isAdmin())
		{
			return true;
		}

		return $this->caseleader_id == auth()->user()->id ? true : false;
	}

	public function IsSalesCc()
	{
		if ($this->isAdmin())
		{
			return true;
		}

		return $this->sales()->find(auth()->user()->id) ? true : false;
	}

	public function IsDefaultQa()
	{
		if ($this->isAdmin())
		{
			return true;
		}

		return $this->defaultqa()->find(auth()->user()->id) ? true : false;
	}

	public function IsAdditionalCc()
	{
		if ($this->isAdmin())
		{
			return true;
		}

		return $this->additional()->find(auth()->user()->id) ? true : false;
	}

	public function IsAssistant()
	{
		if ($this->isAdmin())
		{
			return true;
		}

		return $this->assistant()->find(auth()->user()->id) ? true : false;
	}

	public function IsDefaultCc()
	{
		if ($this->isAdmin())
		{
			return true;
		}

		$hasId	= auth()->user()->groups()->where('groups.name', 'QR.DefaultCc')->first();
		
		return $hasId ? true : false;
	}

	public function IsCocMember()
	{
		if ($this->isAdmin())
		{
			return true;
		}

		$hasId	= auth()->user()->groups()->where('groups.name', 'QR.Claims')->first();
		
		return $hasId ? true : false;
	}

	public function IsAdmin()
	{
		$hasId	= auth()->user()->groups()->where('groups.name', 'QR.Admin')->first();

		return ($hasId || auth()->user()->super()) ? true : false;
	}

	public function IsVisitor()
	{
		$hasId	= auth()->user()->groups()->where('groups.name', 'QR.Visitor')->first();

		return $hasId ? true : false;
	}

	public function IsActiveUser($group = 'initiator')
	{
		switch ($group) {
			case 'initiator':
				return ($this->creator_id > 1 && $this->initiator->ad_status == 1) ? true : false;
			case 'qapic':
				return ($this->qa_id > 1 && $this->qa->ad_status == 1) ? true : false;
			case 'caseleader':
				return ($this->caseleader_id > 1 && $this->caseleader->ad_status == 1) ? true : false;
			default:
				return false;
		}
	}

	public function IsReportNotLock()
	{
		if ($this->external_info)
		{
			if (time() < strtotime($this->external_at))
			{
				return false;
			}

			return true;
		}

		return true;
	}

	public function IsNotLock()
	{
		return $this->locked ? false : true;
	}

	public function IsCanClaim()
	{
		return $this->lockclaim ? false : true;
	}

	public function CanView()
	{
		return ($this->IsInitiator()	|| 
				$this->IsSalesCc()		||
				$this->IsAdditionalCc() || 
				$this->IsDefaultCc()	|| 
				$this->IsDefaultQa()	|| 
				$this->IsQAPIC()		|| 
				$this->IsCaseLeader()	|| 
				$this->IsAssistant()	|| 
				$this->IsCocMember()	||
				$this->IsVisitor()		||
				$this->IsAdmin()) ? true : false;
	}

	public function creator()
	{
		return $this->initiator->display_name;
	}

	public function GetQRDate()
	{
		return $this->created_at->format('d/m/Y h:i:s A');
	}

	public function GetComplaintDate()
	{
		return $this->date->format('d/m/Y');
	}

	public function GetQAPIC()
	{
		return $this->qa_id ? $this->qa->display_name : '';
	}

	public function GetCaseleader()
	{
		return $this->caseleader_id ? $this->caseleader->display_name : '';
	}

	public function GetCountry()
	{
		return $this->country_id ? $this->country->name : '';
	}

	public function GetPacking()
	{
		return $this->pack_id ? $this->packing->name : '';
	}

	public function GetStuffing()
	{
		return $this->stuff_id ? $this->stuffing->name : '';
	}

	public function GetClassification()
	{
		return $this->classification_id ? $this->classification->name : '';
	}

	public function GetQAAssignedUser()
	{
		return $this->qa_assigned_id ? $this->assignor->display_name : '';
	}

	public function GetQAAssignedDate()
	{
		return $this->qa_assigned_at ? $this->qa_assigned_at->format('d/m/Y h:i:s A') : '';
	}

	public function GetCaseleaderAssignedUser()
	{
		return $this->caseleader_assigned_id ? $this->caseleador->display_name : '';
	}

	public function GetCaseleaderAssignedDate()
	{
		return $this->caseleader_assigned_at ? $this->caseleader_assigned_at->format('d/m/Y h:i:s A') : '';
	}

	public function GetLastFeedbackUser()
	{
		$feedback	= $this->comments()->orderBy('created_at', 'DESC')->first();

		return $feedback ? $feedback->creator() : '';
	}

	public function GetLastAssistantUpload()
	{
		$upload	= $this->attachment()->where('section', 'report')->orderBy('attachments.created_at', 'DESC')->first();

		return $upload ? $upload->creator() : '';
	}

	public function GetExternalInfo()
	{
		return $this->external_info ? 'Needed' : 'No need';
	}

	public function GetExternalInfoSubmitDate()
	{
		return $this->external_at ? $this->external_at->format('d/m/Y') : '';
	}

	public function GetExternalModifiedUser()
	{
		return $this->external_updator_id ? $this->externor->display_name : '';
	}

	public function GetExternalModifiedDate()
	{
		return $this->external_updated_at ? $this->external_updated_at->format('d/m/Y h:i:s A') : '';
	}

	public function GetExpectedCompleteDate()
	{
		return $this->caseleader_completed_at ? $this->caseleader_completed_at->format('d/m/Y') : '';
	}

	public function GetReportedUser()
	{
		return $this->caseleader_updator_id ? $this->reportor->display_name : '';
	}

	public function GetReportedDate()
	{
		return $this->caseleader_updated_at ? $this->caseleader_updated_at->format('d/m/Y h:i:s A') : '';
	}

	public function GetReviewedUser()
	{
		return $this->qa_updator_id ? $this->reviewor->display_name : '';
	}

	public function GetReviewedDate()
	{
		return $this->qa_updated_at ?  $this->qa_updated_at->format('d/m/Y h:i:s A') : '';
	}

	public function GetRespondUser()
	{
		return $this->finalresponse_updator_id ? $this->respondor->display_name : '';
	}

	public function GetRespondDate()
	{
		return $this->finalresponse_updated_at ? $this->finalresponse_updated_at->format('d/m/Y h:i:s A') : '';
	}

	public function GetVerifiedUser()
	{
		return $this->verification_updator_id ? $this->verifior->display_name : '';
	}

	public function GetVerifiedDate()
	{
		return $this->verification_updated_at ? $this->verification_updated_at->format('d/m/Y h:i:s A') : '';
	}

	public function GetInformationModifiedUser()
	{
		return $this->information_updator_id ? $this->informator->display_name : '';
	}

	public function GetInformationModifiedDate()
	{
		return $this->information_updated_at ? $this->information_updated_at->format('d/m/Y h:i:s A') : '';
	}

	public function GetClaimModifiedUser()
	{
		return $this->lockclaim_updator_id ? $this->claimor->display_name : '';
	}

	public function GetClaimModifiedDate()
	{
		return $this->lockclaim_updator_at ? $this->lockclaim_updator_at->format('d/m/Y h:i:s A') : '';
	}

	public function GetAssignmentTimeline()
	{
		if ($this->qa_assigned_at)
		{
			$result	= $this->GetTotalDay($this->qa_assigned_at);

			return $this->GetBadge($result);
		}

		return  '';
	}

	public function GetCaseleaderTimeline()
	{
		if ($this->caseleader_assigned_at && $this->qa_assigned_at)
		{
			$result	= $this->GetTotalDay($this->caseleader_assigned_at, $this->qa_assigned_at);

			return $this->GetBadge($result);
		}

		if ($this->caseleader_assigned_at)
		{
			$result	= $this->GetTotalDay($this->caseleader_assigned_at, $this->created_at);

			return $this->GetBadge($result);
		}

		return  '';
	}

	public function GetExternalTimeline()
	{
		if ($this->external_at && $this->external_info && $this->caseleader_assigned_at)
		{
			$result	= $this->GetTotalDay($this->external_updated_at, $this->caseleader_assigned_at);

			return $this->GetBadge($result);
		}

		return  '';
	}

	public function GetReportTimeline()
	{
		if ($this->caseleader_updated_at && $this->caseleader_assigned_at)
		{
			$result	= $this->external_at ? $this->GetTotalDay($this->caseleader_updated_at, $this->external_at) : $this->GetTotalDay($this->caseleader_updated_at, $this->caseleader_assigned_at);

			return $this->GetBadge($result);
		}

		return '';
	}

	public function GetReviewTimeline()
	{
		if ($this->qa_updated_at && $this->caseleader_updated_at)
		{
			$result	= $this->GetTotalDay($this->qa_updated_at, $this->caseleader_updated_at);

			return $this->GetBadge($result);
		}

		return '';
	}

	public function GetRespondTimeline()
	{
		if ($this->finalresponse_updated_at && $this->qa_updated_at)
		{
			$result	= $this->GetTotalDay($this->finalresponse_updated_at, $this->qa_updated_at);

			return $this->GetBadge($result);
		}

		return '';
	}

	public function GetTotalTimeline()
	{
		if ($this->finalresponse_updated_at)
		{
			$result	= $this->GetTotalDay($this->finalresponse_updated_at);
			$label	= ($result <= 7) ? 'success' : 'danger';

			return $this->GetBadge($result, $label);
		}

		$count	= $this->GetTotalDay();

		return $this->GetBadge($count, 'warning');
	}

	public function GetTotalDay($from = '', $to = '')
	{
		if ($from)
		{
			$from	= $from->format('Y-m-d');
			$to		= $to ? $to->format('Y-m-d') : $this->created_at->format('Y-m-d');
		}
		else
		{
			$from 	= $this->created_at->format('Y-m-d');
			$to		= date('Y-m-d');
		}

		$d1		= date_create($from);
		$d2		= date_create($to);
		$diff	= $d1->diff($d2)->format('%a');
		$count	= ($diff > 0) ? $diff : 1;
		$nowork	= $this->GetNonWorkingDay($d2, $d1);
		$result	= $count - $nowork;
		$total	= ($result > 0) ? $result : 1;

		return $total;
	}

	public function GetTotalCalander($type, $showdate = false)
	{
		if ($this->finalresponse_updated_at && in_array($type, ['OFF', 'PH']))
		{
			$result	= Calendar::select('date', 'name')->whereBetween('date', [$this->created_at, $this->finalresponse_updated_at])->where('type', $type)->groupBy('date', 'name')->get();

			if ($showdate)
			{
				$dates	= '';

				foreach ($result as $holiday)
				{
					$dates .= $holiday->date->format('d/m/Y').' ('.$holiday->name.')<br />';
				}

				return $dates;
			}

			return (count($result) > 0) ? '<span class="badge">'.count($result).'</span>' : '';
		}

		return '';
	}

	public function GetNonWorkingDay($d1, $d2)
	{
		$result	= Calendar::select('date')->whereBetween('date', [$d1, $d2])->groupBy('date')->get();

		return count($result);
	}

	public function GetBadge($day, $label = 'primary')
	{
		return '<span class="label label-'.$label.' label-as-badge">'.$day.'</span>';
	}

	public function GetCaseStatus()
	{
		return $this->closed ? 'Closed' : 'Opened';
	}

	public function GetLockStatus()
	{
		return $this->locked ? 'Locked' : 'Unlock';
	}

	public function GetClosed()
	{
		if ($this->closed)
		{
			return 'Case Closed';
		}

		if ($this->locked)
		{
			return 'Case Locked';
		}

		return '';
	}

	public function GetStatus()
	{
		if ($this->notification->prefixkey == 'initiation')
		{
			return '<a href="'.route('qrs.show', $this->id).'" class="default">'.$this->notification->name.'</a>';
		}

		if ($this->locked)
		{
			return $this->GetLink('verification', $this->GetClosed());
		}

		if (in_array($this->notification->prefixkey, ['caseleader' , 'assistant']))
		{
			return $this->GetLink('caseleader');
		}

		if (in_array($this->notification->prefixkey, ['attachment', 'report']))
		{
			return $this->GetLink('report');
		}

		return $this->GetLink();
	}

	public function GetLink($link = '', $name = '')
	{
		$name	= $name ? $name : $this->notification->name;
		$link	= $link ? $link : $this->notification->prefixkey;

		return '<a href="'.route('qrs.'.$link.'.index', $this->id).'" class="default">'.$name.'</a>';
	}

	public function GetURL()
	{
		$prefix	= $this->notification->prefixkey;

		if (in_array($prefix, ['attachment', 'report']))
		{
			return route('qrs.report.index', $this->id);
		}

		if (in_array($prefix, ['feedback', 'review', 'response', 'verification', 'claims']))
		{
			return route('qrs.'.$prefix.'.index', $this->id);
		}

		return route('qrs.show', $this->id);
	}

	public function GetReefer()
	{
		return $this->reefer ? 'Yes' : 'No';
	}

	public function GetRev()
	{
		$link	= 'review';

		return $this->GetReviewedDate() ? $this->GetIcon($link, 'success', 'ok', 'Has Reviewed') : $this->GetIcon($link);
	}

	public function GetFR()
	{
		$link	= 'response';

		return $this->GetRespondDate() ? $this->GetIcon($link, 'success', 'ok', 'Has Reponse') : $this->GetIcon($link);
	}

	public function GetCoC()
	{
		$link	= 'claims';

		if ($this->claims->count() > 0 && $this->lockclaim)
		{
			return $this->GetIcon($link, 'danger', 'ok', 'Claims Locked, Has Claimed');
		}

		if ($this->claims->count() <= 0 && $this->lockclaim)
		{
			return $this->GetIcon($link, 'danger', 'remove', 'Claims Locked, No Claims');
		}

		if ($this->claims->count() > 0)
		{
			return $this->GetIcon($link, 'success', 'ok', 'Has Claimed');
		}

		return $this->GetIcon($link);
	}

	public function GetIcon($link, $text = 'muted', $icon = 'question', $title = 'Pending')
	{
		$link		= route('qrs.'.$link.'.index', $this->id);
		$glyphicon	= 'text-'.$text.' glyphicon glyphicon-'.$icon.'-sign';
		$url		= '<a href="'.$link.'" title="'.$title.'"><span class="'.$glyphicon.' glyphsize-sm"></span></a>';

		return $url;
	}
}