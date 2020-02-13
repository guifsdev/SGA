<?php

namespace App\Lib;

use Illuminate\Support\Arr;
use App\Interfaces\IdUFFCrawlerInterface as Crawler;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use duzun\hQuery;

class IdUFFCrawler implements Crawler
{
	private $base_uri;
	private $timeout;
	private $client;
	private $xpath;
	private $courseId = '^\d{3}023';
	public $failed = true;
	public $bag;
	private $hQueryDom;
	public $jar;

	
	public function __construct($domDocument)
	{
		$this->base_uri = 'https://app.uff.br/iduff/';
		$this->timeout = 20;
		$this->dom = $domDocument;
		$this->jar = new CookieJar();
		$this->bag = collect();

		$this->client = new Client([
			'base_uri' => $this->base_uri,
			'timeout' => $this->timeout,
			'cookies' => true,
		]);
	}

	public function attemptLogin($path, $cpf, $password)
	{
		$response = $this->client->request('GET', 'login.uff');
		$response = $this->client->request('POST', $path,
			[ 
				'form_params' => [
					"login" => "login",
					"login:id" => $cpf,
					"login:senha" => $password,
					"login:btnLogar" => "Logar",
					'javax.faces.ViewState' => 'j_id1'
				],
			]);
		$response = $this->client->request('GET', 'privado/home.uff');
		
		$html = (string) $response->getBody();
		libxml_use_internal_errors(true);
		
		$this->dom->loadHTML($html);
		$this->dom->saveHTML();
		$this->xpath = new \DOMXpath($this->dom);

		$index = null;
		//Try to log the user in
		if($this->login()) {
			//Not in profile page 
			if($this->inEnrolmentSelectionPage()) {

				//But is not in profile page because of multiple enrolments
				$enrolments = $this->getEnrolments();
				$enrolment = $this->getValidEnrolment($enrolments);
				
				if($enrolment->count() == 1) {
					//Let's check for a valid one
					$this->bag['enrolment_number'] = $enrolment->first();
					$index = array_keys($enrolment->toArray())[0];
				} else {
					//Has logged in but enrolment number does not apply
					$this->failed = true;
					return;
				}
			} 
		} else {
			//Something went wrong with cpf or password
			$this->failed = true;
			return;
		}
		$progressPage = $this->toProgressPage($index);
		$this->getProgressData($progressPage);
		$this->failed = false;
		return;
	}
	public function getPersonalData($page)
	{

		
	}
	
	public function getProgressData($page)
	{
		$this->dom->loadHTML($page);

		//Testing hQueryDom
		$this->hQueryDom = hQuery::fromHTML($page);
		//
		$this->dom->saveHTML();
		$this->xpath = new \DOMXpath($this->dom);

		$this->getHeaderData();
		$this->getProgressData();
	}

	public function getProgressData()
	{
		$tds = $this->hQueryDom->find('form#formSuporteIntegralizacao span table:first-child td');

		$cells = array();
		$i = 0;
		foreach($tds as $td) {
			$cells[$i] = $td->text();
			++$i;
		}
		$cells = collect(array_slice($cells, 1));

		$data = collect();

		$cells->map(function($item, $key) use ($cells, &$data) {
			if($key % 2 == 0) {
				$title = preg_replace('/[\r\n\:]+|\s{2}+|\s\*+/', '', $item);
				$value = preg_replace('/\s/', '', $cells[$key+1]);
				$data->put($title, $value);
			}
		});
		$this->bag = $this->bag->merge($data);
	}

	public function getHeaderData()
	{
		$header = $this->dom->getElementById('header');
		
		$name = $this->xpath->query('(//td)[3]/text()', $header)[0]->data;
		$cpf = $this->xpath->query('(//td)[4]/text()', $header)[0]->data;
		$cpf = preg_replace('/\D/', '', $cpf); 

		if(! Arr::exists($this->bag, 'enrolment_number')) {
			$enrolmentNumber = $this->xpath
				->query('(//td)[5]//*[contains(text(), "Aluno")]/text()')[0]->data;
			$this->bag['enrolment_number'] = preg_replace('/\D/', '', $enrolmentNumber);
		}

		$this->bag->put('name', $name);
		$this->bag->put('cpf', $cpf);
	}
	
	public function queryNode($selector, $key)
	{
		$value = $this->xpath->query($selector);
		return Arr::pluck(\iterator_to_array($value), $key)[0];
	}

	public function toProgressPage($index = 0)
	{
		$viewState = $this->xpath->query('//input[@name="javax.faces.ViewState"]/@value');
		$viewState = $viewState[0]->value;

		$response = $this->client->request('POST', 'privado/home.uff', 
			[
				'form_params' => [
					"templatePrincipal2" => "templatePrincipal2",
					"javax.faces.ViewState"=> $viewState,
					"templatePrincipal2:j_id205:{$index}:j_id207" => "templatePrincipal2:j_id205:{$index}:j_id207",
				],
			]
		);
		$response = $this->client
			->request('GET', 'privado/academico/aluno/curriculo/suporteAlunoCurriculoIntegralizado.uff');
		$html = (string) $response->getBody();
		return $html;

	}

	public function getValidEnrolment($enrolments)
	{
		$value = $enrolments->filter(function($e) {
			return preg_match("/{$this->courseId}/", $e);
		});
		return $value;
	}
	
	public function getEnrolments()
	{
		$form = $this->dom->getElementById('templatePrincipal2');
		$nodeList = $this->xpath
			->query('//li[@class="extraUserActions"]/a/text()', $form);
		$enrolments = collect(Arr::pluck(\iterator_to_array($nodeList), 'data')) 
			->map(function($e) {
				return preg_replace('/Aluno - /', '', $e);
			});
		return $enrolments;
	}
	public function inEnrolmentSelectionPage()
	{
		$form = $this->dom->getElementById('templatePrincipal2');
		$nodeList = $this->xpath
			->query('//text()[contains(.,"Tipo de acesso")]', $form);
		if($nodeList->length > 0) {
			return true;
		}
		return false;

	}
	public function login()
	{
		return $this->pageDoesNotHave('//form[@id="login"]');
	}
	public function inProfilePage()
	{
		return $this->pageHas('//img[@id="foto_perfil"]');
	}
	public function hasMultipleEnrolments()
	{
		$form = $this->dom->getElementById('templatePrincipal2');
		$nodeList = $this->xpath->query('//text()[contains(.,"Tipo de acesso")]', $form);
		if($nodeList->length > 0) {
			return true;
		}
		return false;
	}
	public function pageDoesNotHave($selector)
	{
		if($this->xpath->query($selector)->length == 0) {
			return true;
		}
		return false;
	}
	public function pageHas($selector)
	{
		if($this->xpath->query($selector)->length > 0) {
			return true;
		}
		return false;
	}
	public function getHtml()
	{
		echo $this->html;
	}
}
