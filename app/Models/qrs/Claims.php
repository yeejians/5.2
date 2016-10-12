<?php

namespace App\Models\QRS;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

class Claims extends Based
{
	use Activitylog;

	protected $table	= 'claims';
	protected $guarded	= ['id'];

	public function complaint()
	{
		return $this->belongsTo('App\Models\QRS\Complaint', 'complaint_id');
	}

	public function document()
	{
		return $this->belongsTo('App\Models\QRS\Master', 'document_id');
	}

	public function claimstype()
	{
		return $this->belongsTo('App\Models\QRS\Master', 'claimtype_id');
	}

	public function currency()
	{
		return $this->belongsTo('App\Models\QRS\Master', 'currency_id');
	}

	public function GetClaimsType()
	{
		return $this->claimtype_id ? $this->claimstype->name : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}

	public function GetCurrency()
	{
		return $this->currency_id ? $this->currency->name : '';
	}

	public function GetDocument()
	{
		return $this->document_id ? $this->document->name : '';
	}
}