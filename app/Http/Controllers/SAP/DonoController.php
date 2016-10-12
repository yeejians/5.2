<?php

namespace App\Http\Controllers\SAP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Libraries\Helper;
use DB;

class DonoController extends Controller
{
	public function dono()
	{
		return view('sap.rfc.dono');
	}

	public function getdono(Request $request)
	{
		if ($request->ajax())
		{
			$db		= env('DB_WB').'.dbo.OutboundUpdate';
			$table	= env('DB_WB').'.dbo.DDATA2';
			$docno	= $request->input('docno');
			$query	= DB::table($db)->where('WBTICKET', $docno)->get();
			$pkkey	= 'PKKEY';
			$do		= [];
			$so		= [];
			$msg	= '';

			if (count($query)>0)
			{
				$config	= Helper::GetSAPConfig();
				$rfc	= saprfc_open($config);
				$fn		= saprfc_function_discover($rfc, 'Z_DOMAIN_GET_DEL_NO');

				foreach ($query as $result)
				{
					saprfc_import($fn, 'SCORPIO_NO', $result->WBTICKET);
					saprfc_import($fn, 'SALES_NO', $result->SONO);
					saprfc_call_and_receive($fn);

					$dono	= saprfc_export($fn, 'DELIVERY_NO');
					$dono	= intval($dono);

					if ($dono)
					{
						DB::table($table)->where($pkkey, $result->PKKEY)->update([$result->FIELD => $dono]);
						array_push($do, $dono);
					}
					else
					{
						DB::table($table)->where($pkkey, $result->PKKEY)->update([$result->FAILED => 1]);
						array_push($so, $result->SONO);
					}
				}

				saprfc_function_free($fn);
				saprfc_close($rfc);

				if (count($do) > 0)
				{
					$dolist	 = implode(', ', $do);
					$msg	.= $dolist;
				}

				if (count($so) > 0)
				{
					$solist	 = implode(', ', $so);
					$msg	.= ', outbound number not found for SO: '.$solist;
				}

				DB::table('Tracebox.dbo.Log_OutboundUpdate')->insert(['username' => $_SERVER['LOGON_USER'], 'wbticket' => $docno, 'message' => $msg]);

				return $msg;
			}

			return 'No records found';
		}

		abort(403);
	}

	public function autodono()
	{
		$db		= env('DB_WB').'.dbo.OutboundPending';
		$table	= env('DB_WB').'.dbo.FIRST';
		$result	= DB::table($db)->first();
		$pkkey	= 'PKKEY';

		if (is_null($result))
		{
			$message = 'No records found';
		}
		else
		{
			$config	= Helper::GetSAPConfig();
			$rfc	= saprfc_open($config);
			$fn		= saprfc_function_discover($rfc, 'Z_DOMAIN_GET_DEL_NO');

			saprfc_import($fn, 'SCORPIO_NO', $result->WBTICKET);
			saprfc_import($fn, 'SALES_NO', $result->SONO);
			saprfc_call_and_receive($fn);

			$dono	= saprfc_export($fn, 'DELIVERY_NO');
			$dono	= intval($dono);

			saprfc_function_free($fn);
			saprfc_close($rfc);

			if ($dono)
			{
				DB::table($table)->where($pkkey, $result->PKKEY)->update([$result->FIELD => $dono]);

				$message = 'Sales Order: '.$result->SONO.' updated with Outbound Number: '.$dono;
			}
			else
			{
				DB::table($table)->where($pkkey, $result->PKKEY)->update([$result->FAILED => 1]);

				$message = 'Sales Order: '.$result->SONO.' update failed, Outbound Number not found.';
			}

			DB::table('Tracebox.dbo.Log_OutboundUpdate')->insert(['username' => 'LC-DOMAIN\nlwadmin', 'wbticket' => $result->WBTICKET, 'message' => $message]);
		}

		return view('sap.rfc.autodono', compact('message'));
	}
}