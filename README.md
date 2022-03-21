# PHP Request Parser

The missing php functionality to support **put**, **patch**, **delete**, **put**, **FORM** and **MULTIPART** requests handling

[![Latest Stable Version](http://poser.pugx.org/notihnio/php-request-parser/v)](https://packagist.org/packages/notihnio/php-request-parser) [![Total Downloads](http://poser.pugx.org/notihnio/php-request-parser/downloads)](https://packagist.org/packages/notihnio/php-request-parser)  [![License](http://poser.pugx.org/notihnio/php-request-parser/license)](https://packagist.org/packages/notihnio/php-request-parser) [![PHP Version Require](http://poser.pugx.org/notihnio/php-request-parser/require/php)](https://packagist.org/packages/notihnio/php-request-parser)
![example workflow](https://github.com/notihnio/php-request-parser/actions/workflows/run_tests.yml/badge.svg)


## Install

```
composer require notihnio/php-request-parser:2.0.0
```
## Usage

```
use Notihnio\RequestParser\RequestParser;

$request = RequestParser::parse();

//to access params use
$params = $request->params;

//to access uploaded files
$files = $request->files;

//to access headers use
$headers = $request->headers;

//to access cookies use
$cookies = $request->cookies;

```

## Support for Symfony, Laravel in combination with Swoole, Roadrunner
If you want to use New Era application servers like Roadrunner or Swoole it's highly recommended passing Laravel or Symfony request instance, as parameter, in order to avoid memory leaks

```
//laravel
use \Illuminate\Http\Request;

//$request found from controller
$parsedRequest = RequestParser::parse($request);
```
```
//symfony
use \Symfony\Component\HttpFoundation\Request

//$request found from controller
$parsedRequest = RequestParser::parse($request);
```

## Atlernative Usage
```
use Notihnio\RequestParser\RequestParser;

RequestParser::parse();

//to access params
$params = $_PUT or ($_DELETE, $_PATCH etc.. according to the request type)

//to access uploaded files
$files = $_FILES
```

## Authors

* **Notis Mastrandrikos**

## License

This project is licensed under the MIT License
