# Spa API

This api facilitates the creation of services and reservations for a Spa.


### Workflow

The workflow of this API is as follows:

1. Admins will **create the spa service** by specifying a `name` and `price`.
   <br/><br/>
2. In order to make a reservation, the **created service** needs an associated **schedule**, we will create it by specifying 
   a `day`(format: d/m/y) `time available from`(format: H:i --> 09:00) and `time available to`(format: H:i --> 13:00).
   <br/><br/>
3. Customers can make **reservations** for the hours available to the service, for this, they have to specify the `day`(format: d/m/y) and `time`(format: H:i)
   in which the service is available, their `name`,`email` and the ID of the service to reserve.

- Customers can check the availability of a **service** by specifying a `day`(format: d/m/y).


## PHP, Symfony & PostgreSQL

<br/>

This repository is a PHP skeleton with Symfony & PostgreSQL designed for quickly getting started developing an API.
Check the [Getting Started](#getting-started) for full details.

## Technologies

* [PHP 8.1](https://www.php.net/releases/8.1/en.php)
* [Symfony 6](https://symfony.com/releases/6.0)
* [PostgreSQL 14](https://www.postgresql.org/about/news/postgresql-14-released-2318/)
* [PHPUnit](https://phpunit.readthedocs.io/en/9.5/)
* [Docker](https://www.docker.com/)
* [Make](https://www.gnu.org/software/make/manual/make.html)

## Pattern Development

* [Domain Driven Design](https://semaphoreci.com/blog/domain-driven-design-microservices)
* [Hexagonal Architecture](https://medium.com/ssense-tech/hexagonal-architecture-there-are-always-two-sides-to-every-story-bc0780ed7d9c)
* [CQRS](https://learn.microsoft.com/en-us/azure/architecture/patterns/cqrs)
* [Event Sourcing](https://learn.microsoft.com/en-us/azure/architecture/patterns/event-sourcing)


## External libraries

* [lambdish/phunctional](https://github.com/Lambdish/phunctional)
* [ramsey/uuid](https://github.com/ramsey/uuid)
* [fakerphp/faker](https://fakerphp.github.io/)
* [mockery/mockery](https://github.com/mockery/mockery)
* [symfony/profiler-pack](https://symfony.com/doc/current/profiler.html)
* [twig/twig](https://twig.symfony.com/doc/2.x/installation.html)

## Getting Started

Within the [Makefile](Makefile) you can handle the entire flow to get everything up & running:

1. Install `make` on your computer, if you do not already have it.
2. Build the Docker image: `make build`
3. Start the application: `make up`
4. Create and load migrations: `make migrations`

or

1. Install `make` on your computer, if you do not already have it.
2. Build the Docker image: `make install`

As you could see on the [Makefile](Makefile) script, you could just avoid those steps and just execute `make up`, as
**build** is dependant of it.

Go to `http://localhost:8080/api/health` or `http://localhost:8080` to see that everything is up & running! <br/><br/>
If you get an error for the var folder, just create the **var/cache/dev** directories in the root of the project and give it read and write permissions.
<br/><br/>

Now you can run the test with `make test/all` or `make test` to run with coverage information!

Other possible errors are class recognition, to fix it run `make bash`, `composer dump-autoload` and `php bin/console cache:clear` in that order.



## Overview

This is a very simple API with a `/health` endpoint that connects to the database to check that everything is going
well.

### Structure

```scala
$ tree -L 4 src

src
|-- Health // Bounded Context: Features related to the health logc
|    `-- Application
|       |-- Model // The DTOs representing the Response of the Query Handler 
|       |   |-- GetHealthResponse.php
|       |-- Query
|       |   |-- GetHealthQuery.php
|       |-- Service // Handlers for the given Application queries
|       |   |-- GetHealthHandler.php
|    `-- Domain
|       |-- Model // Entities related to the bounded context 
|       |   |-- Health.php
|       |-- Repository
|       |   |-- HealthRepositoryInterface.php 
|    `-- Infrastructure
|       |-- Api // Concrete implementation of the API endpoints
|       |   |-- HealthController.php
|       |   |-- routes.yaml // Specific definition of the routes regarding this Bounded Context
|       `-- Repository // Concrete repository implementations
|           |-- HealthRepository.php
```

This skeleton is based on
a [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html) approach, so you
could find the first basic layers:

> You could find here two amazing articles ([here](https://www.educative.io/blog/clean-architecture-tutorial)
> and [here](https://www.freecodecamp.org/news/modern-clean-architecture/)) explaining the Clean Architecture with Java!
> (credits to [@bertilMuth](https://twitter.com/BertilMuth) and [@ryanthelin](https://dev.to/ryanthelin)).

### Application

The main orchestrator. Interacts with the events received through the Message Handler and the services are the ones in
charge of interacting with the Domain layer.

### Infrastructure

Here you will find the different files to interact with the outside, which implements the contract defined in the Domain
layer. In this folder you will find

* `Api`: Here you will have the classes that handle the REST endpoints and the Request/Response
* `Repository`: Here it is the persistence layer, which interact with the PostgreSQL database, decoupling the rest of
  the application and being easy to change the database engine.

### Domain

Any of your domain Entities,ValueObjects, or Services, that models your business logic. These classes should be completely isolated
of any external dependency or framework, but interact with them. This layer should follow the Dependency Inversion
principle.

## Decisions made when creating the application and tools used

- `Hexagonal Arquitecture`: This pattern has been chosen because it uses a clear and organized structure for the development of applications,
  as well as its ease of maintainability, scalability and testing


- `CQRS`: This pattern allows for separating read and write operations, which improves scalability, reliability,
  simplifies business logic and improves runtime performance.


- `DDD`:  It has been decided to develop the application with DDD because it helps to improve the understanding and communication of business,
  providing a flexible structure and facilitating code reuse.


- `Shared directory`: This custom directory is based on the repository https://github.com/CodelyTV/php-ddd-example,
  it contains the common code that the application may have and defines the classes necessary to carry out CQRS, DDD etc.


- `Domain Events`: Domain events have been decided to be implemented in case the application requires it in the future.


- `Symfony Profiler`: This tool has been used to obtain information related to the application such as queries made to the database,
  event history and in general helps for debugging. We can access the Profiler through the following link when the application is running: http://localhost:8080/_profiler


- `Mockery and Faker Libraries`: These libraries have been used to help in the testing environment. With Mockery, we can create fake test objects that are used as dependencies in unit tests,
  thereby isolating classes and testing desired functionality. Faker helps us generate random data for our tests, which helps test features more thoroughly.
