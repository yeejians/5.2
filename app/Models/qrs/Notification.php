<?php

namespace App\Models\QRS;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

class Notification extends Based
{
	use Activitylog;

	protected $table = 'notifications';
}