<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CP\AttachmentTrait;
use App\Models\CP\Menu;
use DB;

class HomeController extends Controller
{
	use AttachmentTrait;

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
		$user	= auth()->user();
		$menu	= Menu::where('root_id', 0)->orderBy('sequence')->get();

		return view('home.index', compact('user', 'menu'));
	}

	public function calendar(Request $request)
	{
		if ($request->ajax())
		{
			$list	= [];
			$lists	= [];

			$year	= $request->input('year');
			$month	= $request->input('month');

			$result	= DB::table('calendars')->whereRaw('YEAR(date) = ? AND MONTH(date) = ?', [$year, $month])->get();

			foreach ($result as $key)
			{
				$list['badge']	= false;
				$list['date']	= date_format(date_create($key->date), 'Y-m-d');
				$list['body']	= '<p class="lead">'.$key->name.'</p>';

				switch ($key->type)
				{
					case 'PH':
						$list['title']		= 'Public Holiday';
						$list['classname']	= 'bg-danger';
						break;
					case 'SPH':
						$list['title']		= 'Replacement Holiday';
						$list['classname']	= 'bg-success';
						break;
					case 'OFF':
						$list['title']		= 'Weekend';
						$list['classname']	= 'bg-warning';
						break;
					default:
						$list['title']		= 'Alternative Saturday Off';
						$list['classname']	= 'bg-primary';
						break;
				}
				array_push($lists, $list);
			}
			return json_encode($lists);
		}

		return view('home.calendar');
	}
}