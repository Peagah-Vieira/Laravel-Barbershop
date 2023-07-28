# Laravel Barbershop

Agendas personalizadas com painel administrativo com diversas funcionalidades.

## Funcionalidades

- Painel com barra de navegação e barra lateral
- Compromissos personalizados
- Calendário personalizado
- Alertas personalizados
- Pesquisa personalizada
- Tabelas personalizadas
- Paginação personalizada
- Gráficos em tempo real
- Autenticação de 2 fatores (2FA)
- traduzível
- Responsivo
- Tema claro e escuro
- Mensagens flash com sweetalert

## Demonstração em vídeo

https://www.youtube.com/watch?v=hwnjnKsOFYg

## Rodando localmente

Clonar o projeto

```bash
git clone https://github.com/Peagah-Vieira/Laravel-Barbershop
```

Instale todas as dependências usando o composer

```bash
composer install
```

Instale todas as dependências usando npm

```bash
npm install
```

Copie o arquivo env de exemplo e faça as alterações de configuração necessárias no arquivo .env

```bash
cp .env.example .env
```

Migrar o banco de dados

```bash
php artisan migrate:fresh --seed
```

Iniciar o servidor

```bash
npm run dev
```

## Running the tests

Para executar testes de recurso e unidade, execute o seguinte comando

```bash
vendor\bin\phpunit
```

Para executar testes de navegador, execute o seguinte comando

```bash
php artisan dusk
```

## Documentação

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)

[![Tailwind](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

[![Jquery](	https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)](https://jquery.com)
