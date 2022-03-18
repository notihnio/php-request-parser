<?php

use \PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class LaravelRequestsTest extends TestCase
{
    public function testGetRequest(): void
    {
        $cookieJar = CookieJar::fromArray([
            'cookie_name' => 'cookie_value'
        ],
            'localhost'
        );

        $client = new Client();
        $response = $client->request(
            "GET",
            'http://localhost:3001?param=1&param2=2',
            [
                'headers' => ['Accept-Encoding' => 'gzip'],
                'cookies' => $cookieJar
            ]
        );

        $responseData = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount(4, $responseData);
        $this->assertCount(0, $responseData["files"]);

        $this->assertCount(2, $responseData["params"]);
        $this->assertEquals("1", $responseData["params"]["param"]);
        $this->assertEquals("2", $responseData["params"]["param2"]);

        $this->assertCount(4, $responseData["headers"]);
        $this->assertEquals("localhost:3001", $responseData["headers"]["host"]);
        $this->assertEquals("GuzzleHttp/7", $responseData["headers"]["user-agent"]);
        $this->assertEquals("gzip", $responseData["headers"]["accept-encoding"]);
        $this->assertEquals("cookie_name=cookie_value", $responseData["headers"]["cookie"]);

        $this->assertCount(1, $responseData["cookies"]);
        $this->assertEquals("cookie_value", $responseData["cookies"]["cookie_name"]);
    }

    public function testPostRequest(): void
    {
        $cookieJar = CookieJar::fromArray([
            'cookie_name' => 'cookie_value'
        ],
            'localhost'
        );

        $client = new Client();
        try {
            $response = $client->request(
                "POST",
                'http://localhost:3001',
                [
                    'headers' => ['Accept-Encoding' => 'gzip'],
                    'cookies' => $cookieJar,
                    'form_params' => [
                        'param' => '1',
                        'param2' => '2'
                    ]
                ]
            );
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            echo $e->getMessage();
        }

        $responseData = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount(4, $responseData);
        $this->assertCount(0, $responseData["files"]);

        $this->assertCount(2, $responseData["params"]);
        $this->assertEquals("1", $responseData["params"]["param"]);
        $this->assertEquals("2", $responseData["params"]["param2"]);

        $this->assertCount(6, $responseData["headers"]);
        $this->assertEquals("localhost:3001", $responseData["headers"]["host"]);
        $this->assertEquals("GuzzleHttp/7", $responseData["headers"]["user-agent"]);
        $this->assertEquals("gzip", $responseData["headers"]["accept-encoding"]);
        $this->assertEquals("application/x-www-form-urlencoded", $responseData["headers"]["content-type"]);
        $this->assertEquals("16", $responseData["headers"]["content-length"]);
        $this->assertEquals("cookie_name=cookie_value", $responseData["headers"]["cookie"]);

        $this->assertCount(1, $responseData["cookies"]);
        $this->assertEquals("cookie_value", $responseData["cookies"]["cookie_name"]);
    }


    public function testPatchRequest(): void
    {
        $cookieJar = CookieJar::fromArray([
            'cookie_name' => 'cookie_value'
        ],
            'localhost'
        );

        $client = new Client();
        try {
            $response = $client->request(
                "PATCH",
                'http://localhost:3001',
                [
                    'headers' => ['Accept-Encoding' => 'gzip'],
                    'cookies' => $cookieJar,
                    'form_params' => [
                        'param' => '1',
                        'param2' => '2'
                    ]
                ]
            );
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            echo $e->getMessage();
        }

        $responseData = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount(4, $responseData);
        $this->assertCount(0, $responseData["files"]);

        $this->assertCount(2, $responseData["params"]);
        $this->assertEquals("1", $responseData["params"]["param"]);
        $this->assertEquals("2", $responseData["params"]["param2"]);

        $this->assertCount(6, $responseData["headers"]);
        $this->assertEquals("localhost:3001", $responseData["headers"]["host"]);
        $this->assertEquals("GuzzleHttp/7", $responseData["headers"]["user-agent"]);
        $this->assertEquals("gzip", $responseData["headers"]["accept-encoding"]);
        $this->assertEquals("application/x-www-form-urlencoded", $responseData["headers"]["content-type"]);
        $this->assertEquals("16", $responseData["headers"]["content-length"]);
        $this->assertEquals("cookie_name=cookie_value", $responseData["headers"]["cookie"]);


        $this->assertCount(1, $responseData["cookies"]);
        $this->assertEquals("cookie_value", $responseData["cookies"]["cookie_name"]);
    }

    public function testDeleteRequest(): void
    {
        $cookieJar = CookieJar::fromArray([
            'cookie_name' => 'cookie_value'
        ],
            'localhost'
        );

        $client = new Client();
        try {
            $response = $client->request(
                "DELETE",
                'http://localhost:3001',
                [
                    'headers' => ['Accept-Encoding' => 'gzip'],
                    'cookies' => $cookieJar,
                    'form_params' => [
                        'param' => '1',
                        'param2' => '2'
                    ]
                ]
            );
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            echo $e->getMessage();
        }

        $responseData = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount(4, $responseData);
        $this->assertCount(0, $responseData["files"]);

        $this->assertCount(2, $responseData["params"]);
        $this->assertEquals("1", $responseData["params"]["param"]);
        $this->assertEquals("2", $responseData["params"]["param2"]);

        $this->assertCount(6, $responseData["headers"]);
        $this->assertEquals("localhost:3001", $responseData["headers"]["host"]);
        $this->assertEquals("GuzzleHttp/7", $responseData["headers"]["user-agent"]);
        $this->assertEquals("gzip", $responseData["headers"]["accept-encoding"]);
        $this->assertEquals("application/x-www-form-urlencoded", $responseData["headers"]["content-type"]);
        $this->assertEquals("16", $responseData["headers"]["content-length"]);
        $this->assertEquals("cookie_name=cookie_value", $responseData["headers"]["cookie"]);


        $this->assertCount(1, $responseData["cookies"]);
        $this->assertEquals("cookie_value", $responseData["cookies"]["cookie_name"]);
    }

    public function testPutRequest(): void
    {
        $cookieJar = CookieJar::fromArray([
            'cookie_name' => 'cookie_value'
        ],
            'localhost'
        );

        $client = new Client();
        try {
            $response = $client->request(
                "DELETE",
                'http://localhost:3001',
                [
                    'headers' => ['Accept-Encoding' => 'gzip'],
                    'cookies' => $cookieJar,
                    'form_params' => [
                        'param' => '1',
                        'param2' => '2'
                    ]
                ]
            );
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            echo $e->getMessage();
        }

        $responseData = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertCount(4, $responseData);
        $this->assertCount(0, $responseData["files"]);

        $this->assertCount(2, $responseData["params"]);
        $this->assertEquals("1", $responseData["params"]["param"]);
        $this->assertEquals("2", $responseData["params"]["param2"]);

        $this->assertCount(6, $responseData["headers"]);
        $this->assertEquals("localhost:3001", $responseData["headers"]["host"]);
        $this->assertEquals("GuzzleHttp/7", $responseData["headers"]["user-agent"]);
        $this->assertEquals("gzip", $responseData["headers"]["accept-encoding"]);
        $this->assertEquals("application/x-www-form-urlencoded", $responseData["headers"]["content-type"]);
        $this->assertEquals("16", $responseData["headers"]["content-length"]);
        $this->assertEquals("cookie_name=cookie_value", $responseData["headers"]["cookie"]);


        $this->assertCount(1, $responseData["cookies"]);
        $this->assertEquals("cookie_value", $responseData["cookies"]["cookie_name"]);
    }

}
