<?php

namespace Libraries;

class Builder
{
	public static function GetMenu($menu, $lists)
	{
		$dropdown	= '';

		if (in_array($menu->id, $lists) or $menu->super())
		{
			$totalChild	= $menu->childMenu->count();

			if (empty ($menu->parent_id))
			{
				foreach ($menu->childMenu as $key)
				{
					$dropdown .= self::GetMenu($key, $lists);
				}

				return $dropdown;
			}

			if ($totalChild > 0)
			{
				$dropdown .= '<li class="dropdown-submenu"><a href="'.route($menu->route).'">'.$menu->label.'</a>';
				$dropdown .= '<ul class="dropdown-menu">';

				foreach ($menu->childMenu as $key)
				{
					if ($key->childMenu->count() > 0)
					{
						$dropdown .= self::GetMenu($key, $lists);
					}
					else
					{
						if (in_array($key->id, $lists) or $menu->super())
						{
							$dropdown .= '<li><a href="'.route($key->route).'">'.$key->label.'</a></li>';
						}
					}
				}

				$dropdown .= '</ul></li>';
			}
			else
			{
				$dropdown .= '<li><a href="'.route($menu->route).'">'.$menu->label.'</a></li>';
			}
		}

		return $dropdown;
	}

	public static function GetTree($tree, $id, $route = 'cp.menu.show')
	{
		$drawtree	= '';
		$totalChild	= $tree->child->count();

		$drawtree  .= '<li><a href="'.route($route, $tree->id).'"'.($tree->id == $id ? ' class="current"' : '').'>'.$tree->label.'</a> '.$tree->GetAllLabel();

		if ($totalChild > 0)
		{
			$drawtree  .= '<ul>';

			foreach($tree->child as $child)
			{
				if ($child->child->count() > 0)
				{
					$drawtree .= self::GetTree($child, $id, $route);
				}
				else
				{
					$drawtree .= '<li><a href="'.route($route, $child->id).'"'.($child->id == $id ? ' class="current"' : '').'>'.$child->label.'</a> '.$child->GetAllLabel().'</li>';
				}
			}

			$drawtree  .= '</ul>';
		}

		$drawtree  .= '</li>';

		return $drawtree;
	}
}