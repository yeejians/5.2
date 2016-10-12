<?php

namespace App\Models\QRS;

use App\Models\CP\Based;

class Reminder extends Based
{
	protected $table	= 'complaint_reminder';
	protected $dates	= ['date'];

	public function pic()
	{
		return $this->belongsTo('App\Models\QRS\Person', 'pic_id');
	}

	public function notification()
	{
		return $this->belongsTo('App\Models\QRS\Notification', 'notification_id');
	}

	public function GetComplaintDate()
	{
		return $this->date->format('d/m/Y');
	}

	public function GetPIC()
	{
		return $this->pic_id ? $this->pic->display_name : 'MAP-QA';
	}

	public function GetPICEmail()
	{
		return $this->pic_id ? $this->pic->email : 'map-qa@ioiloders.com';
	}

	public function GetLink()
	{
		return '<a href="'.route('qrs.'.$this->notification->prefixkey.'.index', $this->id).'" class="default">'.$this->notification->name.'</a>';
	}

	public function IsAdmin()
	{
		$hasId	= auth()->user()->groups()->where('groups.name', 'QR.Admin')->first();

		return ($hasId || auth()->user()->super()) ? true : false;
	}
}