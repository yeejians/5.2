<?php

namespace App\Models\TP;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

class Reason extends Based
{
	use Activitylog;

	protected $table = 'reasons';
}