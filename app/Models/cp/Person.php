<?php

namespace App\Models\CP;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Person extends Authenticatable
{
	protected $table = 'users';

	protected $hidden = [
		'password', 'remember_token', 'created_at', 'updated_at',
	];

	public function menu()
	{
		return $this->belongsToMany('App\Models\CP\Menu', 'menu_user', 'user_id', 'menu_id');
	}

	public function access()
	{
		return $this->belongsToMany('App\Models\CP\Menu', 'menu_access', 'user_id', 'menu_id');
	}

	public function groups()
	{
		return $this->belongsToMany('App\Models\CP\Group', 'group_user', 'user_id', 'group_id');
	}

	public function scopeActive($query)
	{
		return $query->where([['ad_status', 1], ['is_system', 0]]);
	}

	public function super()
	{
		$group = $this->groups()->where('group_id', 1)->first();

		return is_null($group) ? false : true;
	}
}