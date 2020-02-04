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

		$this->response = $this->client->request('GET', 'login.uff', 
			[
				'cookies' => $jar,
				'headers' => [
					//'Host' => 'app.uff.br',
					//'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:72.0) Gecko/20100101 Firefox/72.0', 
					//'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
					//'Accept-Language' => 'en-US,en;q=0.5',
					//'Accept-Encoding' => 'gzip, deflate, br',
					//'Connection' => 'keep-alive',
					//'Content-Type' => 'application/x-www-form-urlencoded',
					//'Content-Length' => 108,
					//'Origin' => 'https://app.uff.br',
					//'Connection' => 'keep-alive',
					//'Referer' => 'https://app.uff.br/iduff/login.uff',
					//'Upgrade-Insecure-Requests' => 1,
					//'Cache-Control' => 'max-age=0',
				]
			]
		);
		$this->response = $this->client->request('POST', $path,
			[ 
				'form_params' => [
					"login" => "login",
					"login:id" => $cpf,
					"login:senha" => $password,
					"login:btnLogar" => "Logar",
					'javax.faces.ViewState' => 'j_id1'
				],
				'cookies' => $jar,
				
				
			]);
		$this->getHtml();
		//dd($jar);

		//$this->getHtml();
		
		$this->response = $this->client->request('GET', 'privado/home.uff', 
			[ 
				'cookies' => $jar,
				//'debug' => true
			]
		);
		//$this->getHtml();
		dd();
	}

	public function getHtml()
	{
		echo $this->response->getBody();
	}
}
