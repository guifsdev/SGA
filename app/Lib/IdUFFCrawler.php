<?php

namespace App\Lib;

use Illuminate\Support\Arr;
use App\Interfaces\IdUFFCrawlerInterface as Crawler;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use duzun\hQuery;
use Illuminate\Support\Facades\Log;

class IdUFFCrawler implements Crawler
{
	private $base_uri;
	private $timeout;
	private $client;
	private $xpath;
	private $courseId;
	private $hQueryDom;
	private $keyNames;
	private $enrolment;
	public $failed;
	public $bag;
	public $jar;
	
	public function __construct($domDocument)
	{
		$this->base_uri = 'https://app.uff.br/iduff/';
		$this->timeout = 20;
		$this->dom = $domDocument;
		$this->jar = new CookieJar();
		$this->courseId = '^\d{3}023';
		$this->failed = true;
		$this->enrolment = collect();
		$this->bag = collect();

		$this->client = new Client([
			'base_uri' => $this->base_uri,
			'timeout' => $this->timeout,
			'cookies' => true,
		]);

		$this->keyNames = collect([
			'Desdobramento' => 'degree',
			'Habilitação' => 'degree_type',
			'Enfase' => 'emphasis',
			'Currículo' => 'curriculum',
			'Carga horária obrigatória total' => 'total_workload',
			'Carga Horária Obtida' => 'obtained_workload',
			'Carga Horária Cursada' => 'attended_workload',
			'Percentual Concluído' => 'percentage_completed',
			'Coeficiente de Rendimento' => 'performance_coeficient',
			'Situação Atual' => 'current_status',

		]);
	}

	public function verifyCredentials($request, $path = 'login.uff')
	{
		$response = $this->client->request('GET', 'login.uff');
		$response = $this->client->request('POST', $path,
			[ 
				'form_params' => [
					"login" => "login",
					"login:id" => $request->cpf,
					"login:senha" => $request->password,
					"login:btnLogar" => "Logar",
					'javax.faces.ViewState' => 'j_id1'
				],
			]);
		
		$html = (string) $response->getBody();
		$this->hQueryDom = hQuery::fromHTML($html);
		$error = $this->hQueryDom->find('.form-messages-error');
		return !$error ? true : false;
	}

	public function attemptLogin($path, $request)
	{
		$response = $this->client->request('GET', 'login.uff');
		$response = $this->client->request('POST', $path,
			[ 
				'form_params' => [
					"login" => "login",
					"login:id" => $request->cpf,
					"login:senha" => $request->password,
					"login:btnLogar" => "Logar",
					'javax.faces.ViewState' => 'j_id1'
				],
			]);
		$response = $this->client->request('GET', 'privado/home.uff');
		
		$html = (string) $response->getBody();
		libxml_use_internal_errors(true);
		
		$this->hQueryDom = hQuery::fromHTML($html);

		$this->dom->loadHTML($html);
		$this->dom->saveHTML();
		$this->xpath = new \DOMXpath($this->dom);

		//Try to log the user in
		if($this->login()) {
			//Not in profile page 
			if($this->inEnrolmentSelectionPage()) {
				//But is not in profile page because of multiple enrolments
				$enrolments = $this->getEnrolments();
				$enrolment = $this->getValidEnrolment($enrolments);
				
				if($enrolment->count() == 1) {
					//Test
					$this->enrolment->put('number', $enrolment->first());
					$this->enrolment->put('index', array_keys($enrolment->toArray())[0]);
					$this->enrolment->put('selected', false);
					//Test
					
					//Let's check for a valid one
					$this->bag['enrolment_number'] = $enrolment->first();
					//$index = array_keys($enrolment->toArray())[0];
				} else {
					//Has logged in but enrolment number does not apply
					$this->failed = true;
					return;
				}
			}
			//Inspect single enrolment students
			else Log::channel('slack')->info($request, get_object_vars($this));

		} else {
			//Something went wrong with cpf or password
			$this->failed = true;
			return;
		}
		$progressPage = $this->toProgressPage();
		$historyPage = $this->toHistoryPage();
		$personalDataPage = $this->toPersonalDataPage();

		$this->getProgressData($progressPage);
		$this->getPersonalData($personalDataPage);
		$this->getHistoryData($historyPage);
		
		$this->bag = $this->renameKeys($this->bag, $this->keyNames);
		$this->failed = false;

		return;
	}

	public function renameKeys($bag, $source)
	{
		$bag->map(function($value, $oldKey) use ($source, $bag) {
			if($source->has($oldKey)) {
				$newKey = $source->get($oldKey);
				$bag->forget($oldKey);
				$bag->put($newKey, $value);
			} else return $value;
		});
		return $bag;
	}

	public function getHistoryData($page)
	{
		$this->hQueryDom = hQuery::fromHTML($page);
		$cells = $this->hQueryDom->find('.labelNegrito tr td');
		$data = collect();
		$i = 0;
		foreach($cells as $cell) {
			if($i % 2 == 0) {
				$title = preg_replace('/[\r\n\:]+|\s{2}+|\s\*+/', '', $cell->text());
				$value = preg_replace('/\s/', '', $cells[$i+1]);
				$data->put($title, $value);
			}
			++$i;
		}
		$this->bag = $this->bag->merge($data);
	}


	public function toHistoryPage()
	{
		if($this->enrolment->has('index') && !$this->enrolment->get('selected')) {
			$this->selectEnrolment();
		}

		$response = $this->client
			->request('GET', 'privado/declaracoes/private/historico.uff');
		$html = (string) $response->getBody();
		return $html;

	}
	public function selectEnrolment()
	{
		$viewState = $this->hQueryDom->find('input[name="javax.faces.ViewState"]')->val();
		$response = $this->client->request('POST', 'privado/home.uff', 
			[
				'form_params' => [
					"templatePrincipal2" => "templatePrincipal2",
					"javax.faces.ViewState"=> $viewState,
					"templatePrincipal2:j_id205:{$this->enrolment->get('index')}:j_id207" => "templatePrincipal2:j_id205:{$this->enrolment->get('index')}:j_id207",
				],
			]
		);
		$this->enrolment->put('selected', true);
	}

	public function toPersonalDataPage()
	{
		if($this->enrolment->has('index') && !$this->enrolment->get('selected')) {
			$this->selectEnrolment();
		}

		$response = $this->client
			->request('GET', 'privado/iduff/identificacao/editarIdentificacao.uff');
		$html = (string) $response->getBody();
		return $html;
	}
	
	public function getPersonalData($page)
	{
		$this->hQueryDom = hQuery::fromHTML($page);
		
		$ddd = $this->hQueryDom
			->find('input[name="editarIdentificacao:decCelular:inptxtDDDCelular"]')->val();
		$cellPhoneNumber = $ddd . $this->hQueryDom
			->find('input[name="editarIdentificacao:decCelular:txtCelular"]')->val();

		$emailPrimary = $this->hQueryDom
			->find('input[name="editarIdentificacao:j_id425"]')->val();
		$emailSecondary = $this->hQueryDom
			->find('input[name="editarIdentificacao:decEmail:inptxtEmail"]')->val();

		$this->bag = $this->bag->merge(
			collect([
				'cell_phone_number' => $cellPhoneNumber,
				'email_primary' => $emailPrimary,
				'email_secondary' => $emailSecondary,
			])
		);
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
		$this->getAcademicData();
	}

	public function getAcademicData()
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
				$value = preg_replace('/\s|%/', '', $cells[$key+1]);
				$data->put($title, $value);
			}
		});
		$this->bag = $this->bag->merge($data);
	}

	public function getHeaderData()
	{
		$header = $this->dom->getElementById('header');
		
		$name = $this->xpath->query('(//td)[3]/text()', $header)[0]->data;
		$name = $this->splitName($name);
		

		$cpf = $this->xpath->query('(//td)[4]/text()', $header)[0]->data;
		$cpf = preg_replace('/\D/', '', $cpf); 

		if(! Arr::exists($this->bag, 'enrolment_number')) {
			$enrolmentNumber = $this->xpath
				->query('(//td)[5]//*[contains(text(), "Aluno")]/text()')[0]->data;
			$this->bag['enrolment_number'] = preg_replace('/\D/', '', $enrolmentNumber);
		}

		$this->bag->put('first_name', $name[0]);
		$this->bag->put('last_name', $name[1]);
		$this->bag->put('cpf', $cpf);
	}

	public function splitName($name) {
		$name = trim($name);
		$first_name = preg_match('/(^[\w]*)\s/', $name, $matches);
		$first_name = $matches[1];
		$last_name = (strpos($name, ' ') === false) ? '' : trim(preg_replace("/{$first_name}/", '', $name));
		return array($first_name, $last_name);
	}

	public function toProgressPage()
	{
		if($this->enrolment->has('index') && !$this->enrolment->get('selected')) {
			$this->selectEnrolment();
		}

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
