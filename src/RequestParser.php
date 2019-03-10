<?php

namespace Notihnio\RequestParser;

use Notihnio\MultipartFormDataParser\MultipartFormDataParser;

/**
 * Class RequestParser
 *
 * @package Notihnio\RequestParser
 */
class RequestParser
{
    /**
     * @var bool
     */
    private static $isMultipart = false;

    /**
     * Parses request
     *
     * @return \Notihnio\RequestParser\RequestDataset|null
     */
    public static function parse() : ?RequestDataset
    {
        //find method
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $dataset = new RequestDataset();

        if (array_key_exists("CONTENT_TYPE", $_SERVER)) {
            $contentType = strtolower($_SERVER["CONTENT_TYPE"]);
            self::$isMultipart = preg_match('/^multipart\/form-data/', $contentType) ? true : false;
        }

        //handle multipart requests
        if (self::$isMultipart) {
            $multipartRequest =  MultipartFormDataParser::parse();
            if (!is_null($multipartRequest)) {
                $dataset->params = $multipartRequest->params;
                $dataset->files = $multipartRequest->files;
            }
            return $dataset;
        }

        //handle other requests
        if ($method == "POST") {
            $dataset->files = $_FILES;
            $dataset->params = $_POST;
            return $dataset;
        }

        if ($method == "GET") {
            return $dataset;
        }

        $GLOBALS["_".$method] = [];

        //get form params
        parse_str(file_get_contents("php://input"), $params);
        $GLOBALS["_".$method] = $params;
        $dataset->params = $params;

        return $dataset;
    }
}
