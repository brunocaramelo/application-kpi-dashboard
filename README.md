# DASHBOARD KPI APPLICATION


## Technical specifications

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/4e0ecb8eadad4d5e96d6da43d8a97342)](https://app.codacy.com/gh/brunocaramelo/sample_user_app_spa/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

[![Codacy Badge](https://app.codacy.com/project/badge/Coverage/4e0ecb8eadad4d5e96d6da43d8a97342)](https://app.codacy.com/gh/brunocaramelo/sample_user_app_spa/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_coverage)

This application has the following specifications: 

| Tool | Version |
| --- | --- |
| Docker | 24.0.7, |
| Docker Compose | 1.29.2 |
| PHP | 8.3.9 |
| WEBSERVER (FRANKENPHP) | 8.3.9 |
| Mariabd | 10.11.3 |
| Redis | 5.0.0 |
| Sqlite (Unit Tests) | 3.16.2 |
| Laravel Framework | 11.14.* |
| VueJS | 3.0.* |

The application is separated into the following containers

| Service | Image | Motivation
| --- | --- | --- |
| mariadb | mariadb:latest | Main database |
| redis | redis:alpine | Cache provider |
| webserver | frankenphp | Web Server |

## Requirements
    - Docker
    - Docker Daemon (Service)
    - Docker Compose

## Installation procedures
    Procedures for installing the application for local use

1- Download repository 
    - git clone https://github.com/brunocaramelo/application-kpi-dashboard.git
       
        - cp docker/docker-compose-env/application.env.example docker/docker-compose-env/application.env
        - cp docker/docker-compose-env/database.env.example docker/docker-compose-env/database.env

2 - Check that the ports:

    - 80 (webserver) 
    
    - 3306(mysql) 

    - 6380(redis) 
     are busy.


3 - Enter the application's home directory and execute the following commands:
    
    1 - docker-compose up on first time to see all process, after that you can run docker-compose up -d (run on background);

    2 - docker compose exec webserver php /app/artisan migrate;

    3 - docker compose exec webserver php /app/artisan db:seed;

    4 - docker compose exec webserver /app/artisan test;

    
## Post Installation

After installation, the access address is:

- http://localhost/login

- user created in seed:
    - email: admin@test.com
    - password: password


## Details

    - SPA (Single Page Applications)

    - Vue 3

    - Pinia (State Manager of Vue)

    - Laravel 11

    - Redis (Cache)

    - Sanctum (Auth Provider)

    - SOLID

    - Unit Tests (Pest)

    - Docker and docker compose
    

## API Documentation

Import to Postman (to test localhost API):

- https://github.com/brunocaramelo/application-kpi-dashboard/blob/main/documentation/api/KPI-API-LOCAL.postman_collection.json
