# General
This file documents the laminas migration of the open source project [passwordcockpit](https://github.com/passwordcockpit/passwordcockpit).

# Specifics

The project backend currently run on a docker container with the following specifics:

- Docker image: php7.2-apache
- Composer: 1.8.0
- Php: 7.2.13
- Zend Engine: 3.2.0
- zend-expressive: 3.2.1
- zendframework/zend-problem-details: 1.0.2

Current composer.lock file used before the migration [can be found here](https://github.com/passwordcockpit/backend/blob/9bf5471bb965501ed911b13413a5225bb65d04f2/composer.lock)

# Steps

## 0 - Ensure you have an up-to-date Composer

### Execution
Everything went correctly

### Additions
There is a typo in the MD: `composer --version` is the correct command to check the version of composer.

## 1 - Install laminas-migration

### Execution
Docker container was missing the `git` command, had to install it manually. After that `composer global require laminas/laminas-migration` worked.

## 2 - Run the migration command

### Execution 
Since I did not have any terminal text editor in the container I just called the laminas-migrate executable directly without linking the $PATH.

Called `~/.composer/vendor/bin/laminas-migration migrate` in the project folder.

Output: 

```
Injecting laminas-dependency-plugin into composer.json
Performing migration replacements
Injecting Laminas\ZendFrameworkBridge\ConfigPostProcessor into /var/www/html/config/config.php

[ERROR] - File is not in expected format; aborting injection       

You will need to manually add the "Laminas\ZendFrameworkBridge\ConfigPostProcessor" in your ConfigAggregator initialization.
                                                                                                                     
[OK] Migration complete!                                                             
```

Namespaces in files got correctly replaced.

### Additions
The current version (format) of the `config.php` file [can be seen here](https://github.com/passwordcockpit/backend/blob/f98fe4da859e41793ab2f400b5352294d30bc250/config/config.php)

There is no documentation on how to correctly add the `Laminas\ZendFrameworkBridge\ConfigPostProcessor` in the `config/config.php` file. The [online documentation link](https://docs.laminas.dev/laminas-zendframework-bridge) does not work.

I reproduced the problem outside the container where I linked the $PATH to the executable and called it like specified, and I got the same result. 

## 3 - Run the migration command

### Execution
Everything went correctly.

## 4 - Install dependencies

### Execution 
Everything went correctly. Installed laminas libraries.

## 5 - Results

Regarding the `config.php` error, I do not think it matters. The file seems to be working fine.

Tests did not work the first time. The problem seems that every exception thrown returns as a 500.

Example of a response:
```
An unexpected error occurred; stack trace:

App\Service\ProblemDetailsException raised in file
/var/www/html/src/Authentication/src/Api/V1/Action/AuthenticationCreateAction.php line 263:
Message:
Stack Trace:
#0 /var/www/html/vendor/laminas/laminas-stratigility/src/Middleware/RequestHandlerMiddleware.php(53):
Authentication\Api\V1\Action\AuthenticationCreateAction->handle(Object(Laminas\Diactoros\ServerRequest))
#1 /var/www/html/vendor/expressive/expressive/src/Middleware/LazyLoadingMiddleware.php(46):
Laminas\Stratigility\Middleware\RequestHandlerMiddleware->process(Object(Laminas\Diactoros\ServerRequest),
Object(Laminas\Stratigility\Next))
#2 /var/www/html/vendor/laminas/laminas-stratigility/src/Next.php(60):
Expressive\Middleware\LazyLoadingMiddleware->process(Object(Laminas\Diactoros\ServerRequest),
Object(Laminas\Stratigility\Next))
#3 .............
```

We use `ProblemDetailsException` as a custom class that extends `ProblemDetailsExceptionInterface`.

Now, using 
```php
return new JsonResponse(
                    [
                        "status" => "401",
                        "Title" => "Unauthorized",
                        "Message" => "Wrong username or password"
                    ],
                    401
                );
```
instead of 
```php
throw new ProblemDetailsException(
                    401,
                    "Wrong username or password",
                    "Unauthorized",
                    "https://httpstatus.es/401"
                );
```

solves the problem, and I managed to make the Login tests work.

Now, our custom class creates the `ProblemDetailsException` through the constructor, while the documentation now uses a `static function create()`. I utilize the latest version of `zend-problem-details`, so I probably think that the problem is due to this difference.
