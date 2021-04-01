<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Access Control List (API REST)

Este projeto foi desenvolvido com [Laravel Framework](https://laravel.com) versão 8.34.0 e [MySQL Server](https://www.mysql.com/) versão 8.0.

## Development server

Após clonar o projeto do [API.ACL](https://github.com/flailton/api.acl) do GitHub, na pasta do projeto, execute os comandos `composer install`, para instalar as dependências do projeto. 

Após finalizado, deve ser criado um Schema com as seguintes características, no Banco de Dados:
- Nome: `acl` (DB_DATABASE)
- Username = `root` (DB_USERNAME)
- Password = `root` (DB_PASSWORD)
*Caso queira alterar essas informações, será necessário ajustar o arquivo .env (na raíz do projeto).

Após realizada a configuração do banco de dados, deverão ser executadso os comandos `php artisan migrate` e `php artisan db:seed`, nessa ordem.

Em seguida execute o comando `php artisan serve` para iniciar o ambiente de desenvolvimento. 

O ambiente ficará acessível através do endereço `http://localhost:8000/`, ou através de uma porta diferente (informada no terminal), caso esta já esteja ocupada.

## Requisitos Funcionais (RF)

Requisitos funcionais, caracterizam exigências da aplicação que devem ser atendidas através de suas funcionalidades.

RF1: Deve ser possível a visualização, edição, criação e exclusão de Usuários, conforme as permissões atualmente definidas.

RF2: O sistema deve restringir o acesso do Usuário a funcionalidades não definidas nas permissões de sua Função.

RF3: Deve ser possível gerenciar as Permissões de cada Função, conforme as permissões atualmente definidas.

## Requisitos Não Funcionais (RNF)

Requisitos não funcionais, caracterizam exigências do sistema que afetam o seu comportamento, sua arquitetura, tecnologias etc. E não estão necessariamente ligadas a funcionalidades do sistema.

RNF1: O front-end e o back-end do sistema devem estar desacoplados, divididos entre uma API REST e uma outra aplicação, responsável pelo front-end, que irá consumir a API.

RNF2: O back-end deve ser desenvolvido em PHP (7.x >), sendo opcional o uso de algum framework.

RNF3: O sistema deve garantir a segurança dos dados, exigindo autenticação de acesso para utilização.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
