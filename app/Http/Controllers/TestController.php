<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Response;
use File;
use COM;
use DB;
use DateTime;
use DateInterval;

use App\Http\Controllers\CP\AttachmentTrait;

use Libraries\Helper;

use App\Models\CP\Attachment;
use App\Models\CP\Menu;

use App\Models\QRS\Complaint;
use App\Models\QRS\Calendar;


class TestController extends Controller
{
	use AttachmentTrait;

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
		$rfc	= new COM('RfcConnector.RfcSession');

		$rfc->RfcSystemData->ConnectString = 'ASHOST='.env('SAP_ASHOST').' SYSNR='.env('SAP_SYSNR');
		$rfc->LogonData->Client = '300';
		$rfc->LogonData->User = env('SAP_USER');
		$rfc->LogonData->Password = env('SAP_PASSWD');
		$rfc->LogonData->Language = 'EN';

		$rfc->LicenseData->owner = '(unregistered DEMO version)';
		$rfc->LicenseData->key = 'Y5Y43I7QU2OZ8FFP4K2926RC73QJ1E';

		if ($rfc->LicenseData->IsValidLicense() == false)
		{
			print 'ERROR: no valid license set. This program won\'t work without a license key<br/>';
			print '<br/>If you do not have a license, get a free evaluation license from <a href="http://rfcconnector.com/shop">http://rfcconnector.com/shop</a><br/>';
			print 'and insert it into this PHP file';
			die;
		}

		$rfc->Connect();

		if ($rfc->Error == true)
		{
			die('ERROR connecting to SAP: '.$rfc->ErrorInfo->Message);
		}

		$fn = $rfc->ImportCall('Z_DOMAIN_GET_SALES_ORDER');

		if ($rfc->Error == true)
		{
			die('ERROR importing function: '.$rfc->ErrorInfo->Message);
		}

		$fn->Importing['SO_NO']->value = '614451';

		$rfc->CallFunction($fn, true);

		foreach ($fn->Tables['ZSS_DOMAIN_SO']->Rows as $row)
		{
			print $row['CONTRACT_NO'];
		}

		$rfc->disconnect();

		/*$config	= Helper::GetSAPConfig();

		$rfc	= saprfc_open($config);
		$fn		= saprfc_function_discover($rfc, 'Z_GET_SALES_ORDER');

		saprfc_import($fn, 'SO_NO', '614451');
		saprfc_call_and_receive($fn);

//		$sono	= saprfc_table_read($fn, 'ZSS_DOMAIN_SO', 1);
		$sono	= saprfc_function_debug_info($fn);

		saprfc_function_free($fn);
		saprfc_close($rfc);

		print_r($sono);
*/
		exit();

/*		if ($group = auth()->user()->groups()->where('groups.name', 'Global.Admin')->first())
		{
			return $group->name;
		}
		
		return 'Public';
*/	}

	public function files()
	{
		DB::setDefaultConnection('qrs');

		$url			= 'E:\dev\5.2\storage\app\attachments\qrs\QRLC000912\initiation\389611463739521.jpg';
		$model			= new Attachment;

		$model->path	= 'FUCK YOU';
		$model->name	= 'FUCK';
		$model->mime	= 'image/jpeg';
		$model->size	= '79842';
		$model->ext		= 'jpg';

		list($width, $height, $image) = getimagesize($url);

		if ($image)
		{
			$model->image	= $image;
			$model->width	= $width;
			$model->height	= $height;
		}

		$model->save();

		echo $model->getKey();

		exit();

		DB::setDefaultConnection('qrs');

		$result	= DB::table('migration_attachment')->where('complaint_id', 592)->first();

		$exist	= Storage::disk('local')->exists($result->path);
		$url	= $url = Storage::url($result->path);
		$file	= storage_path('app').'/'.$result->path;

		return response()->download($file, $result->name);

		echo $exist.'<br />';
		echo '<a href="'.asset($url).'">'.$result->name.'</a><br />';
		echo storage_path('app').'/'.$result->path;

		exit();
	}

	public function segment(Request $request)
	{
		$segments	= $request->segments();
		
		echo last($segments);
	}

	public function timeline()
	{
//		$date	= Carbon::createFromDate(2016, 02, 06, 'Asia/Singapore')->format('Ymd');
//		$total	= $this->GetNextWorkingDay($date);
		$total	= Carbon::now()->addDays(0)->format('d/m/Y');

		echo $total;

		exit();

		$today		= Carbon::now();
		$minDate	= 3;
		$date		= $today->addDays($minDate)->format('d/m/Y');

		echo $date.'<br />';
		echo Carbon::now()->format('d/m/Y').'<br />';
		echo Carbon::now()->dayOfWeek;

//		$date	= Carbon::createFromDate(2016, 05, 01, 'Asia/Singapore');

//		$result	= DB::table('calendars')->where('date', $date->format('Ymd'))->first();

//		echo $result->date;

		exit();


		DB::setDefaultConnection('qrs');

		$result	= Complaint::find(2);
		$nowork	= Calendar::select('date')->whereBetween('date', [$result->caseleader_assigned_at, $result->caseleader_updated_at])->groupBy('date')->get();
		$count	= $result->caseleader_updated_at->diffInDays($result->caseleader_assigned_at);
		$diff	= $count - count($nowork);
		$d1		= date_create($result->created_at->format('Y-m-d'));
		$d2		= date_create(date('Y-m-d'));
		$now	= $d1->diff($d2)->format('%a');

		echo 'Day Taken: '.$count.'<br />No Work: '.count($nowork).'<br />Total :'.($count - count($nowork)).'<br />Now: '.$now;

		exit();
	}

	public function menu()
	{
		$db	= config('database.connections');

		if (array_key_exists('qrs', $db))
		{
			echo 'Yes!!!!';
		}
		else
		{
			print_r($db);
		}

		exit();
	}

	private function GetNextWorkingDay($date)
	{
		$total	= 0;

		while (true)
		{
			$result	= DB::table('calendars')->select('date')->where('date', $date)->first();

			if ($result)
			{
				$date	= Carbon::createFromFormat('Y-m-d', substr($result->date, 0, 10))->addDay()->format('Ymd');
			}
			else
			{
				break;
			}

			$total++;
		}

		return $total;
	}
}