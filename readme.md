# Laravel Code Challenge



## Prerequisites

1. **php**@*7.1.3+*
2. **node**@*10.6.0+*
3. **npm**@*6.9.0+*
4. **mysql**@*5.5.7+*

## Setup Environment

Clone repo

```
git clone git@github.com:jpadi/laravel_code_challenge.git
```

Install Docker

```
cd path/to/code-challenge
docker-compose up -d
```

SSH into docker container
```
docker exec -ti vue-starter sh
```

## Installation

Install the php dependencies using [composer](https://getcomposer.org/):

```
composer install
```

Install the node dependencies using [npm](https://docs.npmjs.com/cli-documentation/):

```
npm install
```

Copy `.env.example` to `.env`:

```
cp .env.example .env
```

Set the following database variables in `.env` file for your development environment:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=123456
```

Run the database migrations using [artisan](https://laravel.com/docs/5.8/artisan):

```
php artisan migrate
```

Start hot reloading for the application's interface:

```
npm run hot
```

Load the application URL in your browser:

```
http://localhost:8008
```

## Documentation Resources

The following are links to documentation websites relevant to the code challange:

* [Laravel](https://laravel.com/docs/5.8)
* [Vue](https://vuejs.org/v2/guide/)
* [Vue Router](https://router.vuejs.org)
* [Vuex](https://vuex.vuejs.org/guide/)
* [Vuetify](https://vuetifyjs.com/en/getting-started/quick-start)
* [Axios](https://github.com/axios/axios)

## About the solution

### Arquitecture

This project is implemented with DDD and CQRS and applying SOLID. The idea to use DDD and CQRS on this
project is for in the feature if it grows it can be adapted to modern architectures like mircroservices. The idea is to create modules that are completely independent on from other and only comunicate by eventbus. So they can have the own database something that bring more robust to the project because if one module fail because some problem with the database the others continue working

### BoundedContext
Are bounded context from DDD. They are in app/BoundedContext The project at the moment has:
- Backoffice where are all the uses cases, repositories for this project
- Core and special bounded context that can be share between other bounded context. Here is all that is generic and can be reused. 

### Modules

In this project every module should be totally independent so in the future every module can pass to be a microservice if is necesary with his own database.
So the rule for this module is that the only way to communicate with other modules is with the eventBus we never import any class from other modules except events

The modules this project has:
- Auth: Is located in BoundedContext/Auth . This module check the token
- Url: Is located in BoundedContext/Url. This module store the urls


### Folder Structure
```
app

    BoundedContext

        Module1

            Application: Here is the uses cases. We should test only from here the services

            Infra: Here is the implementation for the current infraestructure for example Repositories go here. We do integration testing of this folder, for example repositories
            
            Model: Here go the model clases like entities, events...
                    
    Http: here are the controllers. We do feature for every controller here.
```

### Testing

This project do unit, integration and feature testing.

On unit test we test the use case in insulated way. So we test only the services from application folder of every module.
The unit test only test the services mocking all other class ther need as for example the repositories.

On integration we test third parties software or database. So here we test all that is on module infra folder as for example the repositories.

On Feature we test the controllers and it test all correct functionality of a feature.

For unit test execute enter on container vue-starter and execute 
```vendor/bin/phpunit --testsuite="Unit""```

For integration test execute enter on container vue-starter and execute 
```vendor/bin/phpunit --testsuite="Integration""```

For feature test execute enter on container vue-starter and execute 
```vendor/bin/phpunit --testsuite="Feature""```






