<?php

namespace App\Models\STS;

use App\Models\CP\Based;

class Report extends Based
{
	protected $table = 'L5_reports';

	public function exto()
	{
		return $this->hasMany('App\Models\STS\EXTO', 'report_id');
	}

	public function excc()
	{
		return $this->hasMany('App\Models\STS\EXCC', 'report_id');
	}

	public function to()
	{
		return $this->belongsToMany('App\Models\CP\Person', 'L5_report_to', 'report_id', 'user_id');
	}

	public function cc()
	{
		return $this->belongsToMany('App\Models\CP\Person', 'L5_report_cc', 'report_id', 'user_id');
	}

	public function autosend()
	{
		if ($this->autosend)
		{
			return 'Yes';
		}

		return 'No';
	}
}