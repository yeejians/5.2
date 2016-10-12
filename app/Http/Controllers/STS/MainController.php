<?php

namespace App\Http\Controllers\STS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\STS\Report;
use Libraries\Crystal;
use Libraries\Helper;
use DateInterval;
use DateTime;
use Cache;
use Mail;
use PDO;
use COM;
use DB;

class MainController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('selectdb');
    }

	public function index()
	{
		$result	= Report::all();

		return view('sts.main.index', compact('result'));
	}

	public function flushcache()
	{
		Cache::tags('sts')->flush();

		return redirect()->route('sts.index');
	}

	public function doc($id = null)
	{
		if ($result = Report::find($id))
		{
			$filename	= '';
			$fromDate	= new DateTime();
			$toDate		= new DateTime();
			$interval	= new DateInterval('P1M');

			$fromDate->sub($interval);

			return view('sts.main.doc', compact('filename', 'fromDate', 'toDate', 'result'));
		}

		abort(404);
	}

	public function docPost(Request $request, $id)
	{
		if ($id == 2)
		{
			$this->validate($request, [
				'fromDate'	=> 'required',
				'toDate'	=> 'required',
			]);
		}

		if ($result = Report::find($id))
		{
			$fromDate	= '';
			$toDate		= '';

			$ext		= $request->input('ext');

			$filename	= $result->filename.'.'.time().'.'.$ext;
			$rpt		= base_path().'/reports'.$result->filepath.$result->filename;
			$file		= base_path().'/storage/reports/'.$filename;

			$report		= Crystal::ReportGet($rpt);

			if ($result->id == 2)
			{
				$fromDate	= DateTime::createFromFormat('d/m/Y', $request->input('fromDate'));
				$toDate		= DateTime::createFromFormat('d/m/Y', $request->input('toDate'));
				$d1			= Helper::GetDateInfo($fromDate->format('d/m/Y'), 'd-m-Y');
				$d2			= Helper::GetDateInfo($toDate->format('d/m/Y'), 'd-m-Y');
				$query		= DB::connection()->getPdo()->prepare('exec GetPercentage ?,?,?,?,?,?');

				$FromDate	= $fromDate->format('m/d/Y');
				$ToDate		= $toDate->format('m/d/Y');

				$script		= new COM('MSScriptControl.ScriptControl');

				$query->bindParam(1, $FromDate);
				$query->bindParam(2, $ToDate);
				$query->bindParam(3, $Percentage, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 10);
				$query->bindParam(4, $CompletedDoc, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 10);
				$query->bindParam(5, $TotalDoc, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 10);
				$query->bindParam(6, $Overdue, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 10);
				$query->execute();

				$report->FormulaSyntax = 0;
				$report->RecordSelectionFormula = '{v_Rpt_0006_Customize_OTIF.InvoiceDate} in DateTime('.$d1['yy'].', '.$d1['mm'].', '.$d1['dd'].', 00, 00, 00) to DateTime('.$d2['yy'].', '.$d2['mm'].', '.$d2['dd'].', 23, 59, 59)';

				$script->Language = 'VBScript';
				$script->AllowUI = false;

				$script->AddObject('FromDate', $report->ParameterFields(1), true);
				$script->AddObject('ToDate', $report->ParameterFields(2), true);
				$script->AddObject('Pts', $report->ParameterFields(3), true);
				$script->AddObject('CompletedDoc', $report->ParameterFields(4), true);
				$script->AddObject('TotalDoc', $report->ParameterFields(5), true);
				$script->AddObject('Overdue', $report->ParameterFields(6), true);
				$script->AddCode('Function SetParameter(strFromDate, strToDate, strPts, intCompletedDoc, intTotalDoc, intOverdue) 
					FromDate.AddCurrentValue(CDate(strFromDate))
					ToDate.AddCurrentValue(CDate(strToDate))
					Pts.AddCurrentValue(CDbl(strPts))
					CompletedDoc.AddCurrentValue(CDbl(intCompletedDoc))
					TotalDoc.AddCurrentValue(CDbl(intTotalDoc))
					Overdue.AddCurrentValue(CDbl(intOverdue))
				End Function');
				$script->Run('SetParameter', $FromDate, $ToDate, $Percentage, $CompletedDoc, $TotalDoc, $Overdue);
			}

			Crystal::ReportExport($report, $file, $ext);

			return view('sts.main.doc', compact('filename', 'fromDate', 'toDate', 'result'));
		}

		abort(404);
	}

	public function auto($id = null)
	{
		if ($result = Report::find($id))
		{
			if ($result->autosend)
			{
				$filename	= $result->filename.'.'.time().'.'.$result->format;
				$rpt		= base_path().'/reports'.$result->filepath.$result->filename;
				$file		= base_path().'/storage/reports/'.$filename;

				$report		= Crystal::ReportGet($rpt);

				$input_arr	= [];
				$output_arr	= [];

				Crystal::ReportExport($report, $file, $result->format);

				if ($result->id == 1)
				{
					$table		= 'v_Rpt_0002_Customize';

					$date		= date('d/m/Y');
					$pending	= DB::table($table)->count();
					$overdue	= DB::table($table)->where('Overdue', '>=', 1)->count();
					$avg		= $overdue / $pending * 100;
					$avgoverdue	= bcadd($avg, 0, 2);

					$input_arr	= ['@Date@', '@Pending@', '@Overdue@', '@AvgOverDue@'];
					$output_arr	= [$date, $pending, $overdue, $avgoverdue];
				}

				$subject	= str_replace($input_arr, $output_arr, $result->subject);
				$message	= str_replace($input_arr, $output_arr, $result->message);

				$to		= $result->to;
				$cc		= $result->cc;
				$exto	= $result->exto;
				$excc	= $result->excc;

				Mail::send('emails.mail', ['content' => $message], function($email) use ($subject, $to, $cc, $exto, $excc, $file)
				{
					$email->from(config('mail.from.address'), 'Shipping Tracking System');
					$email->bcc(config('mail.bcc.address'), config('mail.bcc.name'));
					$email->replyTo(config('mail.reply.address'), config('mail.reply.name'));

					foreach ($to as $TO)
					{
						$email->to($TO->email, $TO->display_name);
					}

					foreach ($exto as $EXTO)
					{
						$email->to($EXTO->email, $EXTO->name);
					}

					foreach ($cc as $CC)
					{
						$email->cc($CC->email, $CC->display_name);
					}

					foreach ($excc as $EXCC)
					{
						$email->cc($EXCC->email, $EXCC->name);
					}

					$email->subject($subject);
					$email->attach($file);
				});

				return 'OK';
				
			}

			return 'Not Schedule';
		}

		abort(404);
	}

	public function read($name)
	{
		$file = base_path().'/storage/reports/'.$name;

		if (file_exists($file))
		{
			$ext = substr($name, strrpos($name, '.'), strlen($name));
			$len = filesize($file);

			header('Content-type: application/'.$ext);
			header('Content-Length: '.$len);
			header('Content-Disposition: inline; filename='.$name.'');

			readfile($file);
		}

		abort(404);
	}
}