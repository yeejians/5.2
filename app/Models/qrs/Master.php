<?php

namespace App\Models\QRS;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

class Master extends Based
{
	use Activitylog;
	use SoftDeletes;

	protected $table = 'masters';
	protected $dates = ['deleted_at'];

	public function scopeClaimstype($query)
	{
		return $query->where('section', 'claimstype');
	}

	public function scopeClassification($query)
	{
		return $query->where('section', 'classification');
	}

	public function scopeCountry($query)
	{
		return $query->where('section', 'country');
	}

	public function scopeCurrency($query)
	{
		return $query->where('section', 'currency');
	}

	public function scopeDocument($query)
	{
		return $query->where('section', 'document');
	}

	public function scopePacking($query)
	{
		return $query->where('section', 'packing');
	}

	public function scopeStuffing($query)
	{
		return $query->where('section', 'stuffing');
	}
}