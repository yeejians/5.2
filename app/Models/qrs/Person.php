<?php

namespace App\Models\QRS;

use App\Models\CP\Based;

class Person extends Based
{
	protected $table	= 'users';

	public function scopeQa($query)
	{
		return $query->where([
				['country_code', 'MY'],
				['department_name', 'QA'],
				['ad_status', 1],
			]);
	}

	public function scopeUser($query)
	{
		return $query->where([
				['ad_status', 1],
				['is_system', 0],
				['id', '<>', auth()->user()->id], 
			]);
	}

	public function complaints()
	{
		return $this->belongsToMany('App\Models\QRS\Complaint', 'complaint_user', 'user_id', 'complaint_id')->orderBy('complaints.created_at', 'desc');
	}

	public function defaultcc()
	{
		return $this->belongsToMany('App\Models\QRS\Member', 'group_user', 'user_id', 'group_id');
	}

	public function defaultqa()
	{
		return $this->belongsToMany('App\Models\QRS\Member', 'group_user', 'user_id', 'group_id');
	}

	public function cocmember()
	{
		return $this->belongsToMany('App\Models\QRS\Member', 'group_user', 'user_id', 'group_id');
	}

	public function reminders()
	{
		return $this->hasMany('App\Models\QRS\Reminder', 'pic_id');
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

	public function IsCocMember()
	{
		$hasId	= auth()->user()->groups()->where('groups.name', 'QR.Claims')->first();

		return $hasId ? true : false;
	}

	public function IsDefaultCc()
	{
		$hasId	= auth()->user()->groups()->where('groups.name', 'QR.DefaultCc')->first();

		return $hasId ? true : false;
	}

	public function CanViewAll()
	{
		return ($this->IsAdmin()	||
				$this->IsVisitor()	||
				$this->IsCocMember()||
				$this->IsDefaultCc()) ? true : false;
	}
}