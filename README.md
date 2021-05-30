Recommended products API service setup instructions:
===================

### 1. Download project

	git clone https://github.com/mindaugasvcs/symfony-rest-api.git

### 2. Install dependencies via composer

	composer install

### 3. Setting up database

To setup on production server:

1. Create "real" DATABASE_URL environment variable. How you set environment variables, depends on your setup: they can be set at the command line, in your Nginx configuration, or via other methods provided by your hosting service;
2. Or, create a .env.local file like your local development.

To setup on dev environment edit .env and .env.local (for local overrides) files to suit your database server configuration.

#### Create database

	php bin/console doctrine:database:create

For more details see: http://symfony.com/doc/current/book/doctrine.html#configuring-the-database

#### Create database tables

	php bin/console doctrine:migrations:migrate

The command will create empty database tables based on entities.

#### Generate initial data

	php bin/console doctrine:fixtures:load
	
### 3.1. If on production server

Regenerate APP_SECRET variable:

	php -r "echo bin2hex(random_bytes(16));"

Change to production environment:

	APP_ENV=prod
	APP_DEBUG=0

Clear and warm-up Symfony cache:

	php bin/console cache:clear

### 4. Testing

Issue GET request to {your host}/api/products/recommended/{city name}

#### See list of all REST API routes

	php bin/console debug:router

#### Run phpUnit tests

	php vendor/bin/phpunit

### 5. Notes

You must inform users of this service that it uses data provided by LHMT.

For more details see: https://api.meteo.lt

