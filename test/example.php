<?php

// Autoload files using Composer autoload
require_once './vendor/autoload.php';

use Notihnio\RequestParser\RequestParser;
$request = RequestParser::parse();

