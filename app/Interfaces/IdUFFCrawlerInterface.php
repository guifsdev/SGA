<?php

namespace App\Interfaces;


interface IdUFFCrawlerInterface
{
	public function attemptLogin($path, $request);
	public function getHtml();
	public function pageHas($selector);
	public function login();
}
