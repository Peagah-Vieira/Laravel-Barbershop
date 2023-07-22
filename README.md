[![pt-br](https://img.shields.io/badge/lang-pt--br-green.svg)](https://github.com/Peagah-Vieira/Laravel-Barbershop/blob/master/README-br.md)
# Laravel Barbershop

Customized schedules with an administrative panel with several functionalities.

## Functionalities

- Dashboard with navbar and sidebar
- Custom appointments
- Custom calendar
- Custom alerts
- Custom search
- Custom tables
- Custom pagination
- Real-time graphics
- 2-factor authentication (2FA)
- Translatable
- Responsive
- Light and dark theme
- Flash messages with sweetalert

## Video Demonstration

https://www.youtube.com/watch?v=hwnjnKsOFYg

## Running locally

Clone the project

```bash
git clone https://github.com/Peagah-Vieira/Laravel-Barbershop
```

Install the dependencies

```bash
npm install 
composer install
```

Change environment variables

```bash
# Laravel Configuration
# APP_NAME="Barbershop"
# APP_ENV=local
# APP_KEY="GENERATE A KEY"
# APP_DEBUG=true
# APP_URL=http://localhost

# MySQL Configuration
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE="CHANGE-ME"
# DB_USERNAME="CHANGE-ME"
# DB_PASSWORD="CHANGE-ME"
```

Migrate the database

```bash
php artisan migrate:fresh --seed
```

Start the server

```bash
npm run dev
```

## Running the tests

To run feature and unit tests, run the following command

```bash
vendor\bin\phpunit
```

To run browser tests, run the following command

```bash
php artisan dusk
```

## Documentation

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)

[![Tailwind](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

[![Jquery](	https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)](https://jquery.com)
