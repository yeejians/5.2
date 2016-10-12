<?php

namespace App\Models\QRS;

use App\Models\CP\Based;

class Member extends Based
{
	protected $table	= 'groups';
	protected $guarded	= ['id'];

	public function user()
	{
		return $this->belongsToMany('App\Models\QRS\Person', 'group_user', 'group_id', 'user_id');
	}
}