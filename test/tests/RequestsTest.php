<?php

use \PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class RequestsTest extends TestCase
{
    public function testGetRequest(): void
    {
        $cookieJar = CookieJar::fromArray([
            'cookie_name' => 'cookie_value'
        ],
            'localhost:3000'
        );

        $client = new Client();
        $response = $client->request(
            "GET",
            'http://localhost:3000',
            [
                'headers' => ['Accept-Encoding' => 'gzip'],
                'cookies' => $cookieJar
            ]
        );

        $responseData = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $a = 2;
    }

}
