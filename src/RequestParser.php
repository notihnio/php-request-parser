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

        //find headers
        $headers = (is_null($request)) ? getallheaders() : self::parseSymfonyHeaders($request);
        $headers = array_change_key_case($headers, CASE_LOWER);

        $dataset->headers = $headers;

        //get cookies
        $cookies = (is_null($request)) ? $_COOKIE : $request->cookies->all();
        $cookies = array_change_key_case($cookies, CASE_LOWER);
        $dataset->cookies = $cookies;

        $contentType = (array_key_exists("content-type", $dataset->headers)) ? $dataset->headers["content-type"] : "";
        self::$isMultipart = (bool)preg_match('/^multipart\/form-data/', $contentType);

        //handle multipart requests
        if (self::$isMultipart) {
            $multipartRequest =  MultipartFormDataParser::parse($request);
            if (!is_null($multipartRequest)) {
                $dataset->params = $multipartRequest->params;
                $dataset->files = $multipartRequest->files;
            }
            return $dataset;
        }

        //handle other requests
        if ($method === "POST") {
            $dataset->files = (is_null($request)) ? $_FILES : $request->files->all();
            $dataset->params = (is_null($request)) ? $_POST : $request->request->all();
            return $dataset;
        }

        if ($method === "GET") {
            $dataset->params = (is_null($request)) ? $_GET : $request->query->all();
            if (!is_null($request)) {
                $GLOBALS["_".$method] = $request->query->all();
            }
            return $dataset;
        }

        $GLOBALS["_".$method] = [];

        //get form params
        $requestContents = (is_null($request)) ? file_get_contents("php://input") : $request->getContent();

        if (empty($requestContents)) {
            //road runner returns empty content, fallback to framework defaults
            if (!is_null($request)) {
                var_dump($request->files->all());
                $dataset->files = $request->files->all();
                $dataset->params = $request->request->all();
            }
        } else {
            parse_str($requestContents, $params);
            $GLOBALS["_".$method] = $params;
            $dataset->params = $params;
        }
        return $dataset;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request|\Illuminate\Http\Request $request
     *
     * @return array
     */
    private static function parseSymfonyHeaders(SymfonyRequest|LaravelRequest $request) : array {
        $headers = [];
        foreach ($request->headers->all() as $headerName => $header) {
            $headers[$headerName] = (is_array($header)) ? $header[0] : $header;
        }
        return $headers;
    }
}
