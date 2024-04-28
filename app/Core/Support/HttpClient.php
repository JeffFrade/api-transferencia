<?php

namespace App\Core\Support;

use App\Interfaces\ClientHttpInterface;
use GuzzleHttp\Client;

abstract class HttpClient implements ClientHttpInterface
{
    protected $baseUri;
    private $client;


    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri,
        ]);
    }

    public function sendRequest(string $method = 'GET', string $endpoint = '', array $options = []): string
    {
        return $this->client->request($method, $endpoint, $options)
            ->getBody()
            ->getContents();
    }
}
