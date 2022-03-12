# Taskster API

## About

This is the API for the app ([Taskster](https://github.com/nicolas-costa/taskster-app)), 
totally rebuilt using Lumen, the old one has been built using Express and hosted on heroku.

## Requirements

- Docker and docker-compose

## Instalation

The project utilizes [docker](https://docs.docker.com/get-docker/)

```bash
docker-compose up -d
```

Install it's dependencies

```bash
docker-compose -f docker-compose.cli.yml run --rm composer update
```

Set up the 'APP_KEY' vraiable on the env file.   
You can generate one on the internet but I'll leave one site here
* [passwordgenerator.net](https://passwordsgenerator.net/)

Run migrations

```bash
docker-compose -f docker-compose.cli.yml run --rm artisan migrate
```

Run seeders

```bash
docker-compose -f docker-compose.cli.yml run --rm artisan db:seed
```

If everything went well, the service will be running on [localhost](http://localhost:8000)

You should be able to login by using:

```json
{
    "login": "admin",
    "password": "password"
}
```

## Author
Nícolas Costa

##  License
MIT
