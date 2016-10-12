<?php

namespace App\Models\QRS;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

class Comment extends Based
{
	use Activitylog;

	protected $table	= 'comments';
	protected $guarded	= ['id'];
}