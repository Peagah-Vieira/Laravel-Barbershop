
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
    APP_NAME='Barber Shop'
    APP_ENV=local
    APP_KEY='Your APP_KEY'(php artisan key:generate)
    APP_DEBUG=true
    APP_URL=http://localhost
    
    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE='Your database'
    DB_USERNAME=
    DB_PASSWORD=
    
    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    FILESYSTEM_DISK=local
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120
    
    MEMCACHED_HOST=127.0.0.1
    
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    
    MAIL_MAILER=smtp
    MAIL_HOST=mailpit
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    
    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=
    AWS_USE_PATH_STYLE_ENDPOINT=false
    
    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_HOST=
    PUSHER_PORT=443
    PUSHER_SCHEME=https
    PUSHER_APP_CLUSTER=mt1
    
    VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
    VITE_PUSHER_HOST="${PUSHER_HOST}"
    VITE_PUSHER_PORT="${PUSHER_PORT}"
    VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
    VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
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

