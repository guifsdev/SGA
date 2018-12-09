### Requisitos
* Determinar se quer testar local ou por em produção.
	* Caso queira testar localmente precisará de:
		* Ferramentas:
			* [php](http://php.net/downloads.php)
			* [composer](https://getcomposer.org/download/)
			* [apache](https://httpd.apache.org/download.cgi)
			* [mysql](https://www.mysql.com/downloads/). Após instalação, criar o seu usuário e definir uma senha. Em seguida criar o seu banco de dados para ser utilizado pela aplicação.
			* [phpMyAdmin](https://www.phpmyadmin.net/downloads/). Opcional, caso tenha dificuldade em utilizar o terminal.
		* Processamento:
			1. Fazer download ou clonar o projeto
			2. No terminal, navegar até o diretório da aplicação usando `cd`
			3. Emitir o comando `composer install`
			4. Renomear o arquivo `.env.example` para `.env` na raíz do projeto
			5. Editar o arquivo `.env` mudando as variáveis de ambiente `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `MAX_NUM_AJUSTE`, para as suas.
			6. Emitir o comando `php artisan key:generate`
			7. Emitir o comando `php artisan key:migrate`
			8. Emitir o comando `php artisan serve`
	* Para produção, é aconselhável o uso de serviços de computação em nuvem, como AWS, DigitalOcean, Azure, etc. Se o seu ambiente for este, pressupõe-se que ele tenha todas as dependências necessárias citadas anteriormente, bastando fazer o _deployment_ da aplicação de acordo com a documentação do serviço.

### Popular a tabela disciplinas
É necessário popular a tabela com as disciplinas do curso.
