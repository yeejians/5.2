<?php

namespace App\Models\QRS;

use App\Models\CP\Based;

class Calendar extends Based
{
	protected $table = 'calendars';
	protected $dates = ['date'];
}