<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
	protected $appends = ['has_attachment'];
	//
	public function getHasAttachmentAttribute()
	{
		return $this->attachment->count() ? true : false;
	}

	public function attachment()
	{
		return $this->hasMany(Attachment::class);
	}

	public function student()
	{
		return $this->belongsTo(Student::class);
	}
}
