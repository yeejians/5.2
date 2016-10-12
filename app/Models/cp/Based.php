<?php

namespace App\Models\CP;

use Eloquent;
use App\Models\CP\Person;

class Based extends Eloquent
{
	public static function boot()
	{
		parent::boot();

		static::creating(function($post)
		{
			$post->creator_id = auth()->user()->id;
			$post->updator_id = auth()->user()->id;
		});

		static::updating(function($post)
		{
			$post->updator_id = auth()->user()->id;
		});
	}

	public function creator()
	{
		return Person::find($this->creator_id)->display_name;
	}

	public function updator()
	{
		return Person::find($this->updator_id)->display_name;
	}
/*
	public function getDateFormat()
	{
		return 'Y-m-d H:i:s.u';
	}

	public function fromDateTime($value)
	{
		return substr(parent::fromDateTime($value), 0, -3);
	}
*/
}