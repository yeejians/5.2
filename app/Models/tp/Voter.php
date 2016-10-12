<?php

namespace App\Models\TP;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

class Voter extends Based
{
	use Activitylog;

	protected $table = 'voters';

	public function backup()
	{
		return $this->hasMany('App\Models\TP\VoterBackup', 'voter_id');
	}

	public function site()
	{
		return $this->belongsTo('App\Models\CP\Site', 'site_id');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\CP\Person', 'user_id');
	}
}