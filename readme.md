## Quick start JSON API application

[![License](https://poser.pugx.org/neomerx/limoncello-collins/license.svg)](https://packagist.org/packages/neomerx/limoncello-collins)

Limoncello-collins is a pre-configured [JSON API](http://jsonapi.org/) quick start application based on upstream [Laravel](https://github.com/laravel/laravel) and framework agnostic JSON API implementation [neomerx/json-api](https://github.com/neomerx/json-api).

It has less than minimal changes to the upstream so it could be used as an ordinary Laravel template application. 

### Neomerx/json-api

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/neomerx/json-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/neomerx/json-api/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/neomerx/json-api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/neomerx/json-api/?branch=master)
[![Build Status](https://travis-ci.org/neomerx/json-api.svg?branch=master)](https://travis-ci.org/neomerx/json-api)
[![HHVM](https://img.shields.io/hhvm/neomerx/json-api.svg)](https://travis-ci.org/neomerx/json-api)

You can find more information [here](https://github.com/neomerx/json-api).

### Usage

Limoncello-collins ships with

- A few sample models with database migrations and seeds
- JSON API for the models CRUD operations
- Exceptions handling with JSON API Errors support

Adding fully JSON API compatible services is extremely easy. You can use your models with zero modifications. For example all required controller code to handle ```GET resource``` requests might be as simple as this

```php
class AuthorsController extends Controller
{
	public function show($id)
	{
        return $this->getResponse(Author::findOrFail($id));
    }
}
```

The response will have JSON API required headers
```
HTTP/1.1 200 OK
Content-Type: application/vnd.api+json
Host: localhost:8888
```

and body formatted

```json
{
    "data": {
        "attributes": {
            "first_name": "Dan", 
            "last_name": "Gebhardt"
        }, 
        "id": "1", 
        "links": {
            "posts": {
                "linkage": {
                    "id": "1", 
                    "type": "posts"
                }
            }, 
            "self": "http://localhost:8888/authors/1"
        }, 
        "type": "authors"
    }
}
```

### Installation

#### Download latest version

```
$ composer create-project neomerx/limoncello-collins=dev-master --prefer-dist --prefer-dist && cd limoncello-collins/
```

#### Migrate and seed database

For simplicity it uses sqlite database by default. You are free to change database settings before the next step.

In case of sqlite usage you need to create empty database file

```
$ touch storage/database.sqlite
```

Migrate and seed data

```
$ php artisan migrate && php migrate db:seed
```

#### Run HTTP server

An easy way to start development server is

```
$ php artisan serve --port=8888
```

And that's it! The server can serve JSON API. For example a request with ```curl```

```
$ curl -X GET -H "Content-Type: application/vnd.api+json" -H "Accept: application/vnd.api+json" http://localhost:8888/authors/1
```

should return

```json
{
    "data": {
        "type": "authors",
        "id": "1",
        "attributes": {
            "first_name": "Dan",
            "last_name": "Gebhardt"
        },
        "links": {
            "self": "http:\/\/localhost:8888\/authors\/1",
            "posts": {
                "linkage": {
                    "type": "posts",
                    "id": "1"
                }
            }
        }
    }
}
```

### License

This project is a fork from upstream [laravel/laravel](https://github.com/laravel/laravel). All changes to the upstream are licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Versioning

This project is synchronized with upstream ```master``` branch and uses the same version numbers.