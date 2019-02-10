## O Projeto
Trata-se de uma aplicação em [Laravel](https://laravel.com)/PHP cujo objetivo é facilitar o processo de ajuste e emissão de certificados de participação em eventos de atividades complementares do curso de Administração da Univeridade Federal Fluminense.

### Requisitos
Para testes em ambientes locais são necessários os seguintes requisitos:
* Ferramentas:
	* [php](http://php.net/downloads.php)
	* [composer](https://getcomposer.org/download/)
	* [apache](https://httpd.apache.org/download.cgi)
	* [mysql](https://www.mysql.com/downloads/). Após instalação, criar o seu usuário e definir uma senha. Em seguida criar o seu banco de dados para ser utilizado pela aplicação.
	* [phpMyAdmin](https://www.phpmyadmin.net/downloads/). Opcional, caso tenha dificuldade em utilizar o terminal.
* Passo a passo:
	1. Fazer download ou clonar o projeto
	2. No terminal, navegar até o diretório da aplicação usando `cd`
	3. `composer install`
	4. Renomear o arquivo `.env.example` para `.env` na raiz do projeto definindo os parâmetros `DB_*` e `MAX_NUM_AJUSTE`
	5. No terminal:
		* `php artisan key:generate`
		* `php artisan migrate`
		* `php artisan serve`

### Popular a tabela disciplinas
É necessário popular a tabela com as disciplinas do curso.
