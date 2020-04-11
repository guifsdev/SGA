<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Call;

class Attachment extends Model
{
    public $timestamps = true;

	public function show($call, $attachment)
	{
		
		$file = $this->getFile($attachment->file_name, true);
		$mimetype = $file['attrs']['mimetype'];
		$rawData = $file['raw'];
		$originalName = $attachment->file_original_name;

		return response($rawData, 200)
			->header('Content-Type', "${mimetype}")
			->header('Content-Disposition',"attachment; filename='${originalName}'");
	}

	public function getFile($fileName, $recursive)
	{
		$dir = '/';
		$contents = collect(Storage::cloud()->listContents($dir, $recursive));

		$file = $contents
			->where('type', '=', 'file')
			->where('filename', '=', pathinfo($fileName, PATHINFO_FILENAME))
			->where('extension', '=', pathinfo($fileName, PATHINFO_EXTENSION))
			->first(); // there can be duplicate file names!

		$rawData = Storage::cloud()->get($file['path']);

		return ['attrs' => $file, 'raw' => $rawData];
	}
	
}
