# Patricia (Glover) Maker-Checker Task

## Introduction

A maker-checker system revolves around the idea that for any change to be made to user
information by an administrator, it must be approved by a fellow administrator in order to take
effect; and if the request is declined, the change isn’t persisted.


## Table of Contents
1. <a href="#how-it-works">How it works</a>
2. <a href="#technology-stack">Technology Stack</a>
3. <a href="#application-features">Application Features</a>
4. <a href="#api-endpoints">API Endpoints</a>
5. <a href="#setup">Setup</a>
6. <a href="#author">Author</a>
7. <a href="#license">License</a>


## Technology Stack
  - [PHP](https://www.php.net)
  - [Laravel](https://laravel.com)
  - [MySQL](https://www.mysql.com)
  ### Testing tools
  - [PHPUnit](https://phpunit.de) 

## Application Features
* A user can login into the system by providing a valid email and password.
* An authenticated user can logout of the system.
* An authenticated admin can register new user into the system by providing first name, last name, email, role and password of user.
* An authenticated admin can see all pending requests submitted by other admins in the system.
* The system prevents duplication of pending request that is already in the system.
* An authenticated and an authorized admin can approve pending requests submitted by other admins in the system
* An authenticated and an authorized admin can decline pending requests submitted by other admins in the system
* Email is sent to admins in the system except the creator of the request.

## API Endpoints
### Base URL = http://localhost:6060/
Method | Route | Description | Payload
--- | --- | ---|---
`POST` | `/api/auth/login` | login to the system by providing email and password | email and password
`POST` | `/api/auth/logout` | logout of the system | 
`POST` | `/api/users` | Submit request to create a user | first_name, last_name, email , role and password 
`GET` | `/api/users/:id` | Fetch a single user | 
`PATCH` | `/api/users/:id` | Submit request to update a user | first_name, last_name, email
`DELETE` | `/api/users/:id` | Submit request to delete a user |
`GET` | `/api/request/pending` | Fetch all pending requests in the system |
`GET` | `/api/requests/pending/:id` | Fetch a single pending request |
`PATCH` | `/api/requests/approve/:id` | Approve a pending request |
`PATCH` | `/api/requests/decline/:id` | Decline a pending request |

## Setup
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

  #### Dependencies
  - [Docker](https://docs.docker.com/desktop/)
 
  #### Getting Started
  - Install and setup docker
  - Open terminal and run the following commands
    ```
    $ git clone https://github.com/harmlessprince/maker-checker.git
    $ cd maker-checker
    $ cp .env.example .env
    $ docker-compose build app
    $ docker-compose up -d
    $ docker-compose exec app composer install
    $ docker-compose exec app php artisan key:generate
    $ docker-compose exec app php artisan migrate --seed
    ```
    If all goes well 
  - Visit http://localhost:6060/ on your browser to view laravel home
  - Visit http://localhost:8200/ on your browser to view database using phpmyadmin
  - Visit http://localhost:8025/ on your browser to view mailhog to see emails
 
  ### Admin Logins
        email: johndoe@gmail.com
        password: password
        OR
        email: brucelee@gmail.com
        password: password
  ### Testing
  ```
  $ docker-compose exec app php artisan test
  ```
  If correctly setup, all tests should pass
  
  #### Stop Application
  
  ```$ docker-compose down```
  
## Author
 Name: Adewuyi Taofeeq <br>
 Email: realolamilekan@gmail.com <br>
 LinkenIn:  <a href="#license">Adewuyi Taofeeq Olamikean</a> <br>

## License
ISC
