<?php

namespace App\Models\STS;

use App\Models\CP\Based;

class EXTO extends Based
{
	protected $table = 'L5_external_to';
	protected $fillable = ['email', 'name'];

	public function report()
	{
		return $this->belongsTo('App\Models\STS\Report', 'report_id');
	}
}