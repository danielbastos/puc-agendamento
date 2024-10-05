<p align="center">
    <img align="center" src="/public/images/logo.svg" width="150" alt="Agendamento">
    <h1 align="center"> Agendamento </h1>
    <h2 align="center"> Projeto Integrado – Engenharia de Software - PMV </h2>
</p>


## Sobre o projeto

Projeto de análise de um sistema de agendamento, focado em atendimentos médicos, que ajude tanto ao paciente quanto o profissional de saúde na gerência dos horários e marcações.

A função deste é implementar os pontos principai da especificação. A documentação aqui é específica da implementação. 

Com o intuito de facilitar o deploy, a aplicação esta dockerizada e utiliza as ferramentas disponíveis no Laravel para o mesmo. 

## Requisitos ...
- [Docker](https://www.docker.com/)
- [Docker compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com/)

## Executando ...

Clonando o repositório:
``git clone git@github.com:danielbastos/puc-agendamento.git``

Instalado as dependências necessárias:
``docker run --rm --interactive --tty --volume $PWD:/app composer install``

Copiando arquivo de configuração:
``cp .env.example .env``

Executando o projeto:
``sail up -d``

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
