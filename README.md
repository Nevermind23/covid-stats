# Covid stats
A simple application for processing covid statistics.

**NOTE**: Before using this application, please register using `/api/register` endpoint and send returned `token` inside every request with `Authorization: Brearer {token}` header.
Only login and registration page doesn't require authorization header.

## Requirements
- php:^8.0
## Installation
- `git clone git@github.com:Nevermind23/covid-stats.git && cd covid-stats`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- Configure mysql connection
- `php artisan migrate`
- `php artisan octane:start`

## Commands
- `php artisan db:seed` (for saving country data)
- `php artisan process:statistics`

## Available Endpoints

### Authentication endpoints
- `POST` `/api/login`
- `POST` `/api/register`
- `POST` `/api/logout`

### Main endpoints
- `GET` `/api/countries`
- `GET` `/api/statistics`
- `GET` `/api/statistics/{country_code}`

## Testing
- `php artisan test --testsuite=Feature`
