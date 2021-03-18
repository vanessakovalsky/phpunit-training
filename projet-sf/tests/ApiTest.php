<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiTest extends TestCase
{
    public $client;

    public function setUp() : void
    {
        $this->client = new HttpClient();
    }

    public function testSomething(): void
    {
        $response = $this->client->request(
            'GET',
            'https://virtserver.swaggerhub.com/vanessakovalsky/BoardGames/1.0.0/boardgame/1'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        dd($content);
        $this->assertTrue(true);
    }
}
