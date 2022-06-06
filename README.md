## Requirements

PHP 7.4.*

## Install

git clone project

```shell
git clone https://github.com/dmforaname/koltiva.git
```

Create and edit `.env`

```shell
cp .env.example .env
vim .env
```

Edit the following env variables

```env
APP_NAME=
APP_KEY=
APP_URL=
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```


## Install dependencies:

```shell
composer install
php artisan config:cache
php artisan key:generate
php artiasn migrate
php artisan storage:link
```

