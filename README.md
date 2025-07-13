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
| redis | redis:alpine | Event queue storage |
| webserver | frankenphp | Web Server |

## Requirements
    - Docker
    - Docker Daemon (Service)
    - Docker Compose

## Installation procedures
    Procedures for installing the application for local use

1- Download repository 
    - git clone https://github.com/brunocaramelo/sample_user_app_spa.git
       
        we must copy .env.docker-compose to .env with the command below:

        - cp docker/docker-compose-env/application.env.example docker/docker-compose-env/application.env
        - cp docker/docker-compose-env/database.env.example docker/docker-compose-env/database.env

2 - Check that the ports:

    - 80 (webserver) 
    
    - 9000(php-fpm)

    - 3306(mysql) 

    - 6380(redis) 
     are busy.


3 - Enter the application's home directory and execute the following commands:
    
    1 - docker-compose up -d;

    2 - docker compose exec webserver php /app/artisan migrate;

    3 - docker compose exec webserver php /app/artisan db:seed;

    4 - docker compose exec webserver /app/artisan test;

    
### Description of steps (in case of problems)

    1 - so that the images are stored and executed and the instances are uploaded
        
        (NOTE) - due to the composer's delay in bringing in the dependencies, there are 3 alternatives,
        
            1 - RUN sudo docker-compose up; without being a daemon the first time, so that you can check the progress of the installation of dependencies.
            
            2 - Wait 20 minutes or so for the command to be executed, to avoid autoloading for example.
            
            3 - If you have any problems with dependencies, run the command below to secure them.
                sudo docker exec -t php-sample composer install;
    
    2 - for the framework to generate and apply the mapping for the database (SQL), which can be Mysql, PostGres, Oracle, SQL Serve or SQLITE for example.
    
    3 - for the framework to apply changes to the database data, in the case of inserting a first user.
    
    4 - generation of a hash key for use by the system as a validation key.
    
    5 - for the framework to run the test suite.
        - API tests  
        - Unit tests
     
## Post Installation

After installation, the access address is:

- https://localhost

- user created in seed:
    - email: admin@test.com
    - password: password


## Details

    - Vue 3

    - Pinia

    - Laravel 11

    - Redis (Cache)

    - Sanctum

    - SOLID

    - Unit Tests (Pest)

    - Docker and docker compose

