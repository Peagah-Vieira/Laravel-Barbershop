
# Barbearia 

Agendamentos customizados com um painel administrativo com várias funcionalidades.


## Funcionalidades

- Agendamentos Customizados
- Caléndario Customizável
- Barra de pesquisa
- Gráficos em tempo real
- Alertas Customizavéis
- Autenticação em 2 fatores(2FA)
- Multiplataforma
- Tema Dark/Light



## Demonstração

https://www.youtube.com/watch?v=hwnjnKsOFYg


## Rodando localmente

Clone o projeto

```bash
  git clone https://link-para-o-projeto
```

Instale as dependências

```bash
  npm install 
  composer install
```

Inicie o servidor

```bash
  npm run dev
```

Migrar o banco de dados

```bash
  php artisan migrate:fresh --seed
```

## Variáveis de Ambiente

Para rodar esse projeto, você vai precisar adicionar as seguintes variáveis de ambiente no seu .env

```env
    APP_NAME
    APP_ENV
    APP_KEY
    APP_DEBUG
    APP_URL
```
```env
    DB_CONNECTION
    DB_HOST
    DB_PORT
    DB_DATABASE
    DB_USERNAME
    DB_PASSWORD
```
## Stack utilizada

**Front-end:** TailwindCSS

**Back-end:** PHP(Laravel) | Jquery | Filament


## Documentação

[Tailwind CSS](https://tailwindcss.com)
[PHP](https://www.php.net)
[Laravel](https://laravel.com)
[Jquery](https://jquery.com)
[Filament](https://filamentphp.com)

