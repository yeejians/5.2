<?php

namespace App\Models\CP;

use Eloquent;

class Activity extends Eloquent
{
	protected $fillable = [
        'pkkey', 'tablename', 'action', 'message', 'user_id'
    ];

	public function user()
	{
		return $this->belongsTo('App\Models\CP\Person', 'user_id');
	}
}