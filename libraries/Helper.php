<?php

namespace Libraries;

use App\Models\CP\Person;
use App\Models\CP\Menu;
use DB;

class Helper
{
	public static function GetLogonInfo()
	{
		$input			= explode("\\", $_SERVER["LOGON_USER"]);
		$logon_domain	= $input[0];
		$logon_user		= $input[1];
		$logon_ip		= $_SERVER['REMOTE_ADDR'];
		$logon_hostname	= strtoupper(gethostbyaddr($logon_ip));

		$array =	['domain'	=> $logon_domain,
					'username'	=> $logon_user,
					'ip'		=> $logon_ip,
					'host'		=> $logon_hostname];

		return $array;
	}

	public static function GetDateInfo($date = null, $format = null)
	{
		$date	= str_replace('/', '-', $date);
		$day	= empty($date) ? explode('-', date('Y-m-d')) : explode('-', $date);
		$format	= empty($format) ? 'Y-m-d' : $format;

		switch($format)
		{
			case 'd-m-Y':
				$array	= array('dd' => $day[0], 'mm' => $day[1], 'yy' => $day[2]);
				break;
			default:
				$array	= array('yy' => $day[0], 'mm' => $day[1], 'dd' => $day[2]);
				break;
		}

		return $array;
	}

	public static function GetMap($model)
	{
		$map = [];

		if ($model->map)
		{
			$map = explode('-', $model->map);
		}

		array_push($map, $model->id);

		return $map;
	}

	public static function GetUserMenu($model)
	{
		$allow	= DB::table('menu_access')->where('user_id', auth()->user()->id)->lists('menu_id');
		$menu	= $model->sub()->where('hide', 0)->where('publicity', 1)->lists('id')->toArray();
		$lists	= array_merge($allow, $menu);

		array_push($lists, $model->id);

		return $lists;
	}

	public static function GetBlockMenu($lists)
	{
		$block	= DB::table('menu')->where('publicity', 0)->whereIn('id', $lists)->lists('id');

		return $block;
	}

	public static function GetAllowMenu($lists)
	{
		$allow	= DB::table('menu_access')->whereIn('menu_id', $lists)->where('user_id', auth()->user()->id)->lists('menu_id');

		return $allow;
	}

	public static function GetSAPConfig()
	{
		$config	=  ['ASHOST' => env('SAP_ASHOST'),
					'SYSNR' => env('SAP_SYSNR'),
					'CLIENT' => env('SAP_CLIENT'),
					'USER' => env('SAP_USER'),
					'PASSWD' => env('SAP_PASSWD')];

		return $config;
	}

	public static function GetIndex($prefix)
	{
		$index	= 0;

		if (is_null($result	= DB::table('numbers')->where('prefix', $prefix)->first()))
		{
			DB::table('numbers')->insert(['prefix' => $prefix]);

			$index	= 1;
		}

		$index	= $index ? $index : $result->number;
		$len	= 10 - strlen($prefix);
		$refno	= $prefix.str_pad($index, $len, '0', STR_PAD_LEFT);

		return $refno;
	}

//---------------------------------------------------------------------------------------------------------

	public static function SetLoginRecord($url, $user, $logon)
	{
		$lastLoginDate = date("Y-m-d H:i:s");

		DB::table('logins')->insert([
				'url'		=> $url,
				'user_id'	=> $user->id,
				'username'	=> $user->username,
				'computer'	=> $logon['host'],
				'ip'		=> $logon['ip'],
				'date'		=> $lastLoginDate]);

		$user->last_login = $lastLoginDate;
		$user->save();
	}

//----------------------------------------------------------------------------------------------------------

	public static function RefreshMenuMap($Parent = [], $findChild = false)
	{
		if ($findChild)
		{
			if ($Parent->child->count() > 0)
			{
				foreach ($Parent->child as $Child)
				{
					$Child->map = empty($Parent->map) ? $Parent->id : $Parent->map.'-'.$Parent->id;
					$Child->save();

					self::RefreshMenuMap($Child, $findChild);
				}
			}

			return;
		}

		$AllMenu = Menu::where('root_id', 0)->get();

		foreach ($AllMenu as $Menu)
		{
			self::RefreshMenuMap($Menu, true);
		}

		return;
	}

	public static function CanAccess($route)
	{
		$menu = Menu::where('route', $route)->first();

		if (is_null($menu))
		{
			return false;
		}

		if ($menu->super())
		{
			return true;
		}

		if ($menu->publicity)
		{
			return true;
		}

		$allow	= DB::table('menu_access')->where('menu_id', $menu->id)->where('user_id', auth()->user()->id)->first();

		if (is_null($allow))
		{
			return false;
		}

		return true;
	}
}