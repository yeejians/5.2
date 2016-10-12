<?php

namespace App\Models\CP;

use App\Models\CP\Activity;

trait Activitylog
{
	protected $olddata	= [];
	protected $newdata	= [];

	protected static function bootActivitylog()
	{
		static::updating(function ($model){
			$model->getupdate();
		});

		foreach (static::GetModelEvents() as $event)
		{
			static::$event(function ($model) use ($event){
				$model->log($event);
			});
		}
	}

	public function log($event)
	{
		Activity::create([
			'pkkey'		=> $this->id,
			'tablename'	=> $this->getTable(),
			'action'	=> $event,
			'message'	=> $this->normalize($this, $event),
			'user_id'	=> auth()->user()->id
		]);
	}

	public function getupdate()
	{
		$this->newdata	= $this->getDirty();
		$this->olddata	= $this->getOriginal();
	}

	protected function normalize($model, $action)
	{
		$output	= '';

		if ($action == 'updated')
		{
			foreach ($this->newdata as $key => $val)
			{
				$output .= 'column = '.$key.', old = '.str_limit($this->olddata[$key], 500).', new = '.str_limit($val, 500).'; ';
			}

			return $output;
		}

		foreach ($model->toArray() as $key => $val)
		{
			$output	.= 'column = '.$key.', value = '.str_limit($val, 500).'; ';
		}

		return $output;
	}

	protected static function GetModelEvents()
	{
		if (isset(static::$recordEvents))
		{
			return static::$recordEvents;
		}

		return ['created', 'updated', 'deleted'];
	}
}