<?php

namespace App\Http\Controllers\CP;

use App\Models\CP\Attachment;
use File;

trait AttachmentTrait
{
	protected function fileUpload($input, $path, $filter = [])
	{
		$name	= $input->getClientOriginalName();
		$mime	= $input->getClientMimeType();
		$size	= $input->getClientSize();
		$ext	= $input->getClientOriginalExtension();

		if (empty($filter) || in_array($ext, $filter))
		{
			$file	= mt_rand(10000, 99999).time().'.'.$ext;
			$name	= substr($name, 0, -(strlen($name) - strrpos($name, '.')));
			$dir	= env('APP_STORAGE').$path;
			$disk	= $path.$file;
			$url	= $dir.$file;

			if ($input->move($dir, $file))
			{
				$model			= new Attachment;

				$model->path	= $disk;
				$model->name	= $name;
				$model->mime	= $mime;
				$model->size	= $size;
				$model->ext		= $ext;

				list($width, $height, $image) = getimagesize($url);

				if ($image)
				{
					$model->image	= $image;
					$model->width	= $width;
					$model->height	= $height;
				}

				$model->save();
				
				return $model->getKey();
			}
		}

		return false;
	}

	private function fileRemove($id)
	{
		if ($result	= Attachment::find($id))
		{
			File::delete(env('APP_STORAGE').$result->path);

			$result->delete();

			return true;
		}

		return false;
	}

	public function fileDownload($id)
	{
		if ($result	= Attachment::find($id))
		{
			return response()->download(env('APP_STORAGE').$result->path, $result->getname());
		}

		abort(404);
	}

	public function fileRename($id, $name)
	{
		if ($result	= Attachment::find($id))
		{
			$result->name = $name;
			$result->save();

			return true;
		}

		return false;
	}

	public function fileDelete($id)
	{
		if (is_array($id))
		{
			foreach ($id as $file)
			{
				$this->fileRemove($file);
			}

			return true;
		}

		if ($this->fileRemove($id))
		{
			return redirect(url()->previous());
		}

		abort(404);
	}
}