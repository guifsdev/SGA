<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Attachment;

class Call extends Model
{
	protected $appends = ['has_attachments'];
	//
	public function getHasAttachmentsAttribute()
	{
		return $this->attachments->count() ? true : false;
	}

	public function attachments()
	{
		return $this->hasMany(Attachment::class);
	}

	public function student()
	{
		return $this->belongsTo(Student::class);
	}

	public function store($data, $attachments = null)
	{
		$cpf = $data['cpf']; //14537034700

		$call = new Call();
		$call->student_id = $data['student_id'];
		$call->issue = $data['issue'];
		$call->title = $data['title'];
		$call->description = $data['description'];
		$call->status = "Pendente";
		$call->signature = md5(uniqid(rand(), true));

		$result = null;

		if($attachments) {
			DB::transaction(function() use ($call, $attachments, $cpf, &$result) {
				$attachmentAttrs = collect([]);
				$callsDir = $this->getFolderId('calls', false);

				$result = $call->save();

				foreach($attachments as $key => $file) {
					$extension = $file->getClientOriginalExtension();
					$uniqid = uniqid();
					$storageName = $cpf.'-'.$call->id.'-'.$uniqid.'.'.$extension;

					$attrs = [
						'file_name' => $storageName,
						'file_original_name' => $file->getClientOriginalName(),
						'call_id' => $call->id,
						'file_type' => $extension
					];
					//Put attachments in storage
					Storage::cloud()->put($callsDir.'/'.$storageName, file_get_contents($file->getRealPath()));
					$attachmentAttrs->put($key, $attrs);
				}
				$attachmentAttrs = collect($attachmentAttrs)->map(function($attachment) {
					$attachment['created_at'] = \Carbon\Carbon::now();
					$attachment['updated_at'] = \Carbon\Carbon::now();
					return $attachment;
				})->toArray();
				//Save the attachments data
				Attachment::insert($attachmentAttrs);
			});
		} else $result = $call->save();

		if($result) return response([
			"message" => __("calls.success"),
			"signature" => $call->signature
		], 200);
		else return response(["message" => __("calls.failed")], 500);
	}
	public function getFolderId($dirName, $recursive)
	{
		$dir = '/';
		$contents = collect(Storage::cloud()->listContents($dir, $recursive));

		$dir = $contents->where('type', '=', 'dir')
			->where('filename', '=', $dirName)
			->first(); // There could be duplicate directory names!

		if (!$dir) { dd("directory does not exist!"); }
		return $dir['path'];
	}
}
