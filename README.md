# PHP Request Parser

The missing php functionality to support put, patch, delete, etc.. requests handling 

## Install

```
composer require notihnio/php-request-parser:1.0.0
```
## Usage

```
use Notihnio\RequestParser\RequestParser;

$request = RequestParser::parse();

//to access params use
$params = $request->params;

//to access uploaded files
$files = $request->files;
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
