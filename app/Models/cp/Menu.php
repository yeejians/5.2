<?php

namespace App\Models\CP;

use Illuminate\Database\Eloquent\Builder;
use Eloquent;

use Libraries\Helper;

class Menu extends Eloquent
{
	protected $table = 'menu';

	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('menu', function(Builder $builder) {
			$builder->where('menu.id', '>=', 163);
		});
	}

	public function menu()
	{
		return $this->hasMany('App\Models\CP\Menu', 'root_id');
	}

	public function root()
	{
		return $this->belongsTo('App\Models\CP\Menu', 'root_id')->orderBy('sequence');
	}

	public function rootMenu()
	{
		return $this->belongsTo('App\Models\CP\Menu', 'root_id')->where('hide', 0)->orderBy('sequence');
	}

	public function sub()
	{
		return $this->hasMany('App\Models\CP\Menu', 'root_id')->orderBy('sequence');
	}

	public function subMenu()
	{
		return $this->hasMany('App\Models\CP\Menu', 'root_id')->where('hide', 0)->orderBy('sequence');
	}

	public function parent()
	{
		return $this->belongsTo('App\Models\CP\Menu', 'parent_id')->orderBy('sequence');
	}

	public function parentMenu()
	{
		return $this->belongsTo('App\Models\CP\Menu', 'parent_id')->where('hide', 0)->orderBy('sequence');
	}

	public function child()
	{
		return $this->hasMany('App\Models\CP\Menu', 'parent_id')->orderBy('sequence');
	}

	public function childMenu()
	{
		return $this->hasMany('App\Models\CP\Menu', 'parent_id')->where('hide', 0)->orderBy('sequence');
	}

	public function users()
	{
		return $this->belongsToMany('App\Models\CP\Person', 'menu_user', 'menu_id', 'user_id');
	}

	public function access()
	{
		return $this->belongsToMany('App\Models\CP\Person', 'menu_access', 'menu_id', 'user_id');
	}

	public function groups()
	{
		return $this->belongsToMany('App\Models\CP\Group', 'menu_group', 'menu_id', 'group_id');
	}

	public function super()
	{
		return auth()->user()->super();
	}

	public function GetRoot()
	{
		if ($this->root_id)
		{
			return $this->root_id;
		}

		return $this->id;
	}

	public function GetParent()
	{
		if ($this->parent_id)
		{
			return $this->parent_id;
		}
		
		return $this->id;
	}

	public function GetHide()
	{
		if ($this->hide)
		{
			return 'Yes';
		}
		return 'No';
	}

	public function GetSearch()
	{
		if ($this->search)
		{
			return 'Yes';
		}
		return 'No';
	}

	public function GetPublic()
	{
		if ($this->publicity)
		{
			return 'Yes';
		}
		return 'No';
	}

	public function GetRootLabel()
	{
		if ($this->root_id)
		{
			return $this->root->label;
		}

		return $this->label;
	}

	public function GetParentLabel()
	{
		if ($this->parent_id)
		{
			return $this->parent->label;
		}

		return $this->label;
	}

	public function GetHideLabel()
	{
		if ($this->hide)
		{
			return '<span class="label label-default">hide</span>';
		}
		return '';
	}

	public function GetSearchLabel()
	{
		if ($this->search)
		{
			return '<span class="label label-success">search</span>';
		}
		return '';
	}

	public function GetPublicLabel()
	{
		if (empty($this->publicity))
		{
			return '<span class="label label-info">privated</span>';
		}
		return '';
	}

	public function GetAllLabel()
	{
		return $this->GetHideLabel().$this->GetSearchLabel().$this->GetPublicLabel();
	}

	public function GetLink()
	{
		if (empty($this->hide) || $this->parent_id == $this->root_id)
		{
			return '<a href="'.route($this->route).'">'.$this->label.'</a>';
		}

		$lists	= Helper::GetMap($this);
		$model	= $this->root_id ? $this->root->menu() : $this->menu();
		$result	= $model->where('hide', 0)->whereIn('id', $lists)->orderBy('sequence', 'desc')->first();

		return '<a href="'.route($result->route).'">'.$result->label.'</a>';
	}

	public function GetSearchMenu()
	{
		if ($this->search)
		{
			$div = '<form class="navbar-form navbar-right">
						<div class="form-group">
							<input type="text" class="form-control" name="search" placeholder="Search">
						</div>
					</form>';

			return $div;
		}

		return '';
	}
}