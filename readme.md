## Made with [Laravel](https://laravel.com) and [Vuejs](https://vuejs.org)

## Requirements

- PHP 7.2 – 7.4
- HTTP server with PHP support (e.g.: Apache, Nginx, Caddy) (optional)
- [Composer](https://getcomposer.org)
- A supported database: MySQL, PostgreSQL or SQLite

## Installation Guide

### 1. Clone the repository and install dependencies

From your console, run the following commands:

``` bash
cd <WEB_DIRECTORY_FOR_BLOG>
git clone https://github.com/jenky/blog
composer install
```

### 2. Add the DB Credentials & APP_URL

Create your `.env` file from your console:

``` bash
cp .env.example .env
```

Next make sure to create a new database and add your database credentials to your `.env` file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

You might also want to update your website URL inside of the APP_URL variable inside the `.env` file:

```
APP_URL=http://localhost:8000
```

Then generate your application key from your console:

``` bash
php artisan key:generate
```

### 3. Start your development server

``` bash
php artisan serve
```

You should now be able to visit http://localhost:8000 in your browser and start using the application.

> http://localhost:8000, however, is only the *development server* for Laravel. For optimal performance, you'll want to set up the production version, the configuration of which varies depending on your webserver of choice (Apache, Nginx, Caddy etc.)

## Create an User

To create new user or admin simply run

``` bash
php artisan app:user
```

And you will be prompted for the user's name, email and password.

## Testing

``` bash
composer test
```
