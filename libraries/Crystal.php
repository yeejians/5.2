<?php

namespace Libraries;

use COM;

class Crystal
{
	public static function ReportGet($template)
	{
		$host	= config('database.connections.sqlsrv.host');
		$db		= config('database.connections.sqlsrv.database');
		$uid	= config('database.connections.sqlsrv.username');
		$pwd	= config('database.connections.sqlsrv.password');

		$object	= new COM('CrystalReports11.ObjectFactory.1');
		$report	= $object->CreateObject('CrystalDesignRunTime.Application')->OpenReport($template, 1);

		$report->Database->Tables(1)->SetLogOnInfo($host, $db, $uid, $pwd);
		$report->EnableParameterPrompting = 0;
		$report->DiscardSavedData();
		$report->ReadRecords();

		return $report;
	}

	public static function ReportExport($report, $destination, $filetype = 'pdf')
	{
		switch($filetype)
		{
			case 'xls':
				$format = 29;
				break;
			default:
				$format = 31;
				break;
		}

		$report->ExportOptions->FormatType			= $format;
		$report->ExportOptions->DiskFileName		= $destination;
		$report->ExportOptions->DestinationType		= 1;
		$report->ExportOptions->PDFExportAllPages	= true;
		$report->Export(false);
	}
}