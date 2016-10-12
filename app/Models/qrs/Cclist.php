<?php

namespace App\Models\QRS;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

class Cclist extends Based
{
	use Activitylog;

	protected $table	= 'complaint_cclist';
	protected $guarded	= ['id'];
}