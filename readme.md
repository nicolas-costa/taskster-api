# Taskster API

## About

This is the API for the app ( [Taskster](https://github.com/nicolas-costa/taskster-app)), totally rebuilt using Lumen, the old one has been built using Express and hosted on heroku.   
As a matter of simplicity, this API uses an sqlite database.

## Requirements

[Lumen requirements](https://lumen.laravel.com/docs/6.x#server-requirements)

## Instalation

Clone the project

```
git clone https://github.com/nicolas-costa/taskster-api.git
```

Go to the project's folder

```
cd taskster-api
```
Install it's dependencies

```
composer update
```

Set up the 'APP_KEY' vraiable on the env file.   
You can generate one on the internet but I'll leave one site here
* [passwordgenerator.net](https://passwordsgenerator.net/)

Run migrations

```
php artisan migrate
```

Run seeders

```
php artisan db:seed
```

Serve

```
php -S localhost:8000 -t public
```


## Author
Nícolas Costa

## License

WTFPL
