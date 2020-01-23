<h2>Sistema de Crud para teste prático</h2>

<p>Passos para utilizar o projeto</p>

1) Clonar o repositório na pasta destino
2) Criar um banco Mysql com o nome que desejar
3) Realizar a copia do arquivo .env.exemple que está na pasta raiz do projeto colocando o nome como .env (linux: sudo cp .env.example .env)
4) Abrir o arquivo .env com um editor, configurar os campos(APP_URL) com a url local e (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD) de acordo com o banco de dados utilizado 
5) Conceder permissão de gravação para a pasta do projeto (linux: sudo chmod -R 777 /var/www/testecrud/)
5) Digitar o comando 'composer install' no terminal dentro da pasta raiz do projeto
6) Digitar o comando 'php artisan key:generate' dentro da pasta raiz do projeto
7) Digitar o comando 'php artisan migrate' dentro da pasta raiz do projeto
8) Se o projeto estiver dentro de um servidor local, digitar o comando 'php artisan serve'
9) Acessar o link informado no terminal

Ao acessar a pagina, irá visualizar a tela de cadastro.
No topo da tela tem um link 'Lista de Usuários', onde direciona para as paginas que consomem a API

