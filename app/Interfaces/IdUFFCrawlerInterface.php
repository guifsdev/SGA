<?php

namespace App\Interfaces;


interface IdUFFCrawlerInterface
{
	public function init($path, $request);
	public function getHtml();
	public function pageHas($selector);
	public function login();
}
