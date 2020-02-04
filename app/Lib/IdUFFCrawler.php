<?php

namespace App\Lib;

use App\Interfaces\IdUFFCrawlerInterface as Crawler;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class IdUFFCrawler implements Crawler
{
	private $base_uri;
	private $timeout;
	private $client;
	private $response;

	public function __construct($base_uri, $timeout)
	{
		$this->base_uri = $base_uri;
		$this->timeout = $timeout;

		$this->client = new Client([
			'base_uri' => $this->base_uri,
			'timeout' => $this->timeout,
			'cookies' => true,
		]);
	}

	public function login($path, $cpf, $password)
	{
		$jar = new CookieJar();
		$this->response = $this->client->request('POST', $path,
			[ 
				'form_params' => [
					"login" => "login",
					"login:id" => $cpf,
					"login:senha" => $password,
					"login:btnLogar" => "Logar",
					'javax.faces.ViewState' => 'j_id1'
				],
				['cookies' => $jar],
				'headers' => [
					'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0' 
				]
				
			]);
		dd($jar);
		
		$this->response = $this->client->request('GET', 'privado/home.uff', 
			[ 
				'cookies' => $jar,
				'debug' => true
			]
		);
		$this->getHtml();
	}

	public function getHtml()
	{
		return $this->response->getBody();
	}
}
