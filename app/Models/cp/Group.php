<?php

namespace App\Models\CP;

use Eloquent;

class Group extends Eloquent
{
	protected $table = 'groups';

	public function users()
	{
		return $this->belongsToMany('App\Models\CP\Person', 'group_user', 'group_id', 'user_id');
	}

	public function menu()
	{
		return $this->belongsToMany('App\Models\CP\Menu', 'menu_group', 'group_id', 'menu_id');
	}
}