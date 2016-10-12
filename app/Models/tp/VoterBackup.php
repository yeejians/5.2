<?php

namespace App\Models\TP;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

class VoterBackup extends Based
{
	use Activitylog;

	protected $table	= 'voterbackup';
	protected $fillable = ['user_id'];

	public function voter()
	{
		return $this->belongsTo('App\Models\TP\Voter', 'voter_id');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\CP\Person', 'user_id');
	}
}