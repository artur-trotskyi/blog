# BLOG API

php 8.3, laravel 10, mysql 8.0

## Initial local setup

Clone this project

    git clone git@github.com:artur-trotskyi/blog.git

Switch to the docker-compose-lamp folder in project folder and run containers in the background

    cd blog/docker-compose-lamp
    docker compose up -d

Launch the bash in mysql container

    docker compose exec database bash

Create 'blog' database

    mysql -uroot -p
    tiger
    CREATE DATABASE blog;
    exit
    exit

Launch the bash in web container

    docker compose exec webserver bash

Switch to the project folder in docker

    cd /var/www/html

Copy `.env.example` to `.env`

    cp .env.example .env

Install all the dependencies using composer

    composer install

Generate application key

    php artisan key:generate

Generate JWT secret key

    php artisan jwt:secret
    yes

Errors fix

    chmod 777 -R bootstrap/cache
    chmod 777 -R storage

Run migrations (or use dump docker-compose-lamp/data/*.sql)

    php artisan migrate

Run seeders

    php artisan db:seed

Configure your hosts file on main machine (sudo nano /etc/hosts)

    127.0.0.1   blog.local

Check `http://blog.local`

Use https://documenter.getpostman.com/view/14659521/2sA3QmDEQk#02ea974d-9435-4887-8cdb-e0065898ffd1
