<?php

namespace App\Interfaces;


interface IdUFFCrawlerInterface
{
	public function login($path, $cpf, $password);
	public function getHtml();
}
