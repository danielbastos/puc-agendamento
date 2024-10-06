<p align="center">
    <img align="center" src="/public/images/logo.svg" width="150" alt="Agendamento">
    <h1 align="center"> Agendamento </h1>
    <h2 align="center"> Projeto Integrado – Engenharia de Software - PMV </h2>
</p>


## Sobre o projeto

Projeto de análise de um sistema de agendamento, focado em atendimentos médicos, que ajude tanto ao paciente quanto o profissional de saúde na gerência dos horários e marcações.

A função deste é implementar os pontos principai da especificação. A documentação aqui é específica da implementação. 

Com o intuito de facilitar o deploy, a aplicação esta dockerizada e utiliza as ferramentas disponíveis no Laravel para o mesmo. 

## Requisitos
- [Docker](https://www.docker.com/)
- [Docker compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com/)

## Preparando o projeto

Clonando o repositório:

``git clone git@github.com:danielbastos/puc-agendamento.git``

Instalado as dependências necessárias:

``docker run --rm --interactive --tty --volume $PWD:/app composer install``

Copiando arquivo de configuração:

``cp .env.example .env``

Executando o projeto:

``sail up -d``

Instalando dependências do Frontend:
``sail npm install``

Build do front:

``sail npm run build``

Gerando a chave de segurança aleatória (Usada para validar cookies):

``php artisan key:generate``

Executando o script de geração das tabelas do banco de dados:

``sail php artisan migrate``

Criando dados básicos do sistema

`` sail php artisan db:seed``

## Passos opcionais
Para facilitar, existe um gerador de dados fake onde vai criar usuários, médicos e atendendentes para facilitar testes na aplicação.

``sail php artisan db:seed --class=FakeDataSeeder``

## Executando

Aplicação: ``http://127.0.0.1:1080``
Servidor fake de e-mails: ``http://localhost:18025/``
