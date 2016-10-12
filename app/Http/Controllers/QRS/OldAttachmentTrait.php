<?php

namespace App\Http\Controllers\QRS;

use App\Models\QRS\OldAttachment;
use Storage;

trait OldAttachmentTrait
{
	public function olddownload($id)
	{
		if ($result	= OldAttachment::find($id))
		{
			return response()->download(storage_path('app').'/'.$result->path, $result->name);
		}

		abort(404);
	}

	public function olddelete($id)
	{
		if (is_array($id))
		{
			foreach ($id as $file)
			{
				$this->oldremove($file);
			}

			return true;
		}

		if ($this->oldremove($id))
		{
			return redirect(url()->previous());
		}

		abort(404);
	}

	private function oldremove($id)
	{
		if ($result	= OldAttachment::find($id))
		{
			Storage::delete($result->path);

			$result->delete();

			return true;
		}

		return false;
	}
}