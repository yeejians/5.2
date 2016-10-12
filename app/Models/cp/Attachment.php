<?php

namespace App\Models\CP;

use App\Models\CP\Activitylog;
use App\Models\CP\Based;

class Attachment extends Based
{
	use Activitylog;

	protected $table = 'attachments';

	public function getsize($unit = '')
	{
		if ((!$unit && $this->size >= 1<<30) || $unit == 'GB')
		{
			return number_format($this->size/(1<<30), 2).' GB';
		}

		if ((!$unit && $this->size >= 1<<20) || $unit == 'MB')
		{
			return number_format($this->size/(1<<20), 2).' MB';
		}

		if ((!$unit && $this->size >= 1<<10) || $unit == 'KB')
		{
			return number_format($this->size/(1<<10), 2).' KB';
		}

		return number_format($this->size)." bytes";
	}

	public function getname()
	{
		return $this->name.'.'.$this->ext;
	}

	public function getlink()
	{
		$link 	= 'href="'.route('file.download', $this->id).'"';
		$img	= '';

		if ($this->image)
		{
			$link	= 'href="'.asset($this->path).'" class="attachment" data-source="'.route('file.download', $this->id).'" title="'.$this->getname().'"';
			$img	= '<img src="'.asset($this->path).'" width="20px" height="20px" /> ';
		}

		return '<a '.$link.'>'.$img.$this->getname().'</a>';
	}

	public function getblock($access = true)
	{
		$div  = '<div class="attachment-container">';
		$div .= '<div class="row">
					<div class="col-xs-2 col-xs-fixed alignRight"><label>File Name:</label></div>
					<div class="col-xs-10"><a href="'.route('file.download', $this->id).'">'.$this->getname().'</a><br />';
		
		if ($this->image)
		{
			$div .= '<div class="attachment-wrapper">
						<a href="'.asset($this->path).'" class="attachment" data-source="'.route('file.download', $this->id).'" title="'.$this->getname().'"><img src="'.asset($this->path).'" width="320px" /></a>
					 </div>';
		}

		$div .= '</div></div>
				 <div class="row">
					<div class="col-xs-2 col-xs-fixed alignRight"><label>File Size:</label></div>
					<div class="col-xs-10">'.$this->getsize().'</div>
				 </div>
				 <div class="row">
					<div class="col-xs-2 col-xs-fixed alignRight"><label>Uploaded By:</label></div>
					<div class="col-xs-10">'.$this->creator().'</div>
				 </div>
				 <div class="row">
					<div class="col-xs-2 col-xs-fixed alignRight"><label>Uploaded Date:</label></div>
					<div class="col-xs-10">'.$this->created_at->format('d/m/Y h:i:s A').'</div>
				 </div>';

		if (($this->creator_id == auth()->user()->id) && $access)
		{
			$div .= '<div class="row">
						<div class="col-xs-2 col-xs-fixed">&nbsp;</div>
						<div class="col-xs-10"><a href="'.route('file.delete', $this->id).'" class="btn btn-danger btn-xs" onclick="return confirmAction(\'Confirm Delete?\')"><span class="glyphicon glyphicon-trash"></span>Delete</a></div>
					 </div>';
		}

		return $div.'</div>';
	}
}