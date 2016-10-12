<?php

namespace App\Models\QRS;

use App\Models\CP\Based;

class Feedback extends Based
{
	protected $table	= 'complaint_feedback';

	public function GetTimeFull()
	{
		return $this->created_at->format('h:i A \o\n l d/m/Y');
	}

	public function GetTime()
	{
		return $this->created_at->diffForHumans();
	}

	public function GetPosition()
	{
		return $this->creator_id == auth()->user()->id ? ' right' : ' left';
	}

	public function GetBGColor()
	{
		return $this->creator_id == auth()->user()->id ? ' style="background-color: #f5fbee;"' : '';
	}

	public function GetContent()
	{
		if ($this->type == 'comment')
		{
			return $this->comment;
		}

		$content = '<div class="wrapper'.$this->GetPosition().'"><div class="attach">';

		if ($this->image)
		{
			$content .= '<a href="'.asset($this->path).'" class="attachment" data-source="'.route('file.download', $this->id).'" title="'.$this->name.'"><img src="'.asset($this->path).'" width="320px" /></a>';
		}
		else
		{
			$content .= '<a href="'.route('file.download', $this->id).'"><h1><span class="glyphicon glyphicon-file"></span></h1>'.$this->name.'</a>';
		}

		return $content.'</div></div>';
	}
}