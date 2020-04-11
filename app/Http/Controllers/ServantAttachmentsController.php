<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Call;

class ServantAttachmentsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:servant');
	}
    public function show(Call $call, Attachment $attachment)
	{
		return (new Attachment())->show($call, $attachment);
	}
}
