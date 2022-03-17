<?php

namespace Notihnio\RequestParser;

use Notihnio\MultipartFormDataParser\MultipartFormDataParser;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Illuminate\Http\Request as LaravelRequest;

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
    private static bool $isMultipart = false;

    /**
     * Parses request
     *
     * @param $request \Symfony\Component\HttpFoundation\Request|\Illuminate\Http\Request|null
     * @return \Notihnio\RequestParser\RequestDataset|null
     */
    public static function parse(SymfonyRequest|LaravelRequest|null $request = null) : ?RequestDataset
    {
        //find method
        $method = (is_null($request)) ? strtoupper($_SERVER['REQUEST_METHOD']) : $request->getMethod();
        $dataset = new RequestDataset();

        $contentType = "";
        if (is_null($request)) {
            if (array_key_exists("CONTENT_TYPE", $_SERVER)) {
                $contentType = strtolower($_SERVER["CONTENT_TYPE"]);
            }
        } else {
            $contentType = $request->getContentType();
        }

        self::$isMultipart = (bool)preg_match('/^multipart\/form-data/', $contentType);

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
        if ($method === "POST") {
            $dataset->files = (is_null($request)) ? $_FILES : $request->files;
            $dataset->params = (is_null($request)) ? $_POST : $request->request->all();
            return $dataset;
        }

        if ($method === "GET") {
            $dataset->params = (is_null($request)) ? $_GET : $request->request->all();
            if (!is_null($request)) {
                $GLOBALS["_".$method] = $request->request->all();
            }
            return $dataset;
        }

        $GLOBALS["_".$method] = [];

        //get form params
        $requestContents = (is_null($request)) ? file_get_contents("php://input") : $request->getContent(true);
        parse_str($requestContents, $params);
        $GLOBALS["_".$method] = $params;
        $dataset->params = $params;

        return $dataset;
    }
}
